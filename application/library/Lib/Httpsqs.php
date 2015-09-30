    <?php

    /**
     * httpsqs 操作类
     * Class Lib_Httpsqs
     */
    class Lib_Httpsqs
    {
        /**
         * @var string字符集
         */
        private $charset = 'utf-8';
        /**
         * @var string服务器地址
         */
        public $host = '127.0.0.1';
        /**
         * @var string使用的端口地址
         */
        public $port = '2000';
        /**
         * @var string
         * 日志目录
         */
        private $log_dir = "/tmp";

        public $auth = NULL;

        private $timeout = 1;

        public function __construct($host = null, $port = 0)
        {
            $this->host = ($host !== null) ? $host : $this->host;
            $this->port = ($port !== 0) ? $port : $this->port;
        }

        /**
         * 写队列
         * post/get
         */
        public function writeQs($queue_name, $data)
        {
            if ($this->auth == NULL) return false;
            $url = "/?name=" . trim($queue_name) . "&opt=put&auth=" . $this->auth . "&charset=" . $this->charset;

            $result = $this->postRequest($url, $data);
            if ($result['response'] != "HTTPSQS_PUT_OK") {
                // 写日志
                $logs = "date: " . date("Y-m-d H:i:s") . "\r\n";
                $logs .= "url:" . $url . ".\r\n";
                $logs .= "data:" . print_r($result, true) . "\r\n\r\n";
                file_put_contents($this->log_dir . "/httpsqs_error_" . date("Y-m-d") . ".log", $logs, FILE_APPEND);
                return ($this->map_status($result['response'])) ? $this->map_status($result['response']) : $result['response'];
            }
            return $result['pos'];
        }

        /**
         * 读队列
         */
        public function readQs($queue_name)
        {
            if ($this->auth == NULL) return false;
            $url = "/?name=" . $queue_name . "&opt=get&auth=" . $this->auth . "&charset=" . $this->charset;
            $result = $this->getRequest($url);
            if (empty($result['pos'])) {
                // 写日志
                $logs = "date:" . date("Y-m-d H:i:s") . "\r\n";
                $logs .= "url:" . $url . "\r\n";
                $logs .= "result:" . print_r($result, true) . "\r\n\r\n";
                file_put_contents($this->log_dir . "/httpsqs_error_" . date("Y-m-d") . ".log", $logs, FILE_APPEND);
//                return ($this->map_status($result['response'])) ? $this->map_status($result['response']) : $result['response'];
                return $result['response'];
            }
            return $result;
        }

        /**
         * 获取数据
         */
        private function getRequest($request_url)
        {
            $socket = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
            if (!$socket) {
                return array("response" => "can not open httpsqs");
            }
            $out = "GET " . $request_url . " HTTP/1.1\r\n";
            $out .= "Host: " . $this->host . "\r\n";
            $out .= "Connection: close\r\n";
            $out .= "\r\n";
            fwrite($socket, $out);
            $pos_value = 0;
            while (($line = fgets($socket)) != "") {
    //            var_dump($line);
                if (strstr($line, "HTTP/1.1")) {

                } elseif (strstr($line, "Content-Type")) {

                } elseif (strstr($line, "Cache-Control")) {

                } elseif (strstr($line, "Pos")) {
                    list($name, $pos_value) = explode(":", $line);
                } elseif (strstr($line, "Date")) {

                } elseif (strstr($line, "Content-Length")) {

                } elseif (strstr($line, "Connection")) {

                } elseif (!empty($line)) {
                    $response = $line;
                }
            }
            if ($pos_value < 0) {
                return false;
            }
            fclose($socket);
            return array("pos" => intval($pos_value), "response" => $response);
        }

        /**
         * post请求数据
         */
        private function postRequest($url, $data = '')
        {
            if (is_array($data)) {
                foreach ($data as &$v) {
                    $v = urlencode($v);
                }
            }
            $content = json_encode($data);
            $socket = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
            if (!$socket) {
                return false;
            }
            $out = "POST " . $url . " HTTP/1.1\r\n";
            $out .= "Host: " . $this->host . "\r\n";
            $out .= "Content-Length: " . strlen($content) . "\r\n";
            $out .= "Connection: close\r\n";
            $out .= "\r\n";
            $out .= $content;
            fwrite($socket, $out);
            $len = -1;
            // 获取数据
            while (($line = trim(fgets($socket))) != "") {
                if (strstr($line, "Content-Length:")) {
                    list($cl, $len) = explode(" ", $line);
                }
                if (strstr($line, "Pos:")) {
                    list($pos_key, $pos_value) = explode(" ", $line);
                }
                if (strstr($line, "Connection: close")) {
                    $close = true;
                }
            }
            if ($len < 0) {
                return false;
            }
            $body = @fread($socket, $len);
            fclose($socket);
            return array('pos' => intval($pos_value), 'response' => $body);
        }

        /**
         * @param $auth设置验证
         */
        public function setAuth($auth)
        {
            $this->auth = $auth;
        }

        private function map_status($status)
        {
            $map = array(
                "HTTPSQS_PUT_OK" => "入队列成功",
                "HTTPSQS_PUT_ERROR" => "入队列失败",
                "HTTPSQS_PUT_END" => "队列已满",
                "HTTPSQS_GET_END" => "已取出所有数据",
                "HTTPSQS_RESET_OK" => "重置成功",
                "HTTPSQS_RESET_ERROR" => "重置失败",
                "HTTPSQS_MAXQUEUE_OK" => "更改最大队列数量成功",
                "HTTPSQS_MAXQUEUE_CANCEL" => "更改最大队列数量失败",
                "HTTPSQS_SYNCTIME_OK" => "修改间隔时间成功",  //修改定时刷新内存缓冲区内容到磁盘的间隔时间
                "HTTPSQS_SYNCTIME_CANCEL" => "修改间隔时间失败",  //修改定时刷新内存缓冲区内容到磁盘的间隔时间
                "HTTPSQS_AUTH_FAILED" => "密码校验失败",
                "HTTPSQS_ERROR" => "全局错误" //即指令、参数错误等
            );
            return isset($map[$status]) ? $map[$status] : false;
        }

        /**
         * 查看指定队列位置点的内容
         */
        public function viewPos($queue_name, $pos_id)
        {
            if ($this->auth == NULL) return false;
            $url = "/?name=" . $queue_name . "&opt=view&pos=" . $pos_id . "&auth=" . $pos_id . "&charset=" . $this->charset;
        }

        /**
         * 获取队列状态
         */
        public function getStatusJson($queue_name)
        {
            if ($this->auth == null) return false;
            $url = "/?name=$queue_name&opt=status_json&auth=" . $this->auth . "&charset=" . $this->charset;;
            return $this->getRequest($url);
        }

        /**
         * 重置某个队列
         */
        public function resetQs($queue_name)
        {
            if ($this->auth) return false;
            $url = "/?name=" . $queue_name . "&opt=reset&auth=" . $this->auth . "&charset=" . $this->charset;
            return $this->getRequest($url);
        }

        /**
         * 设置一条队列最大数量
         */
        public function setQsNumber($queue_name, $num)
        {
            if ($this->auth) return false;
            $url = "/?name=" . $queue_name . "&opt=maxqueue&num=" . intval($num) . "&auth=" . $this->auth . '&charset=' . $this->charset;
            return $this->getRequest($url);
        }
    }