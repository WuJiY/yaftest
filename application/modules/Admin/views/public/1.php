<?php include __DIR__ . "/../public/header.phtml"; ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <!-- # 	节点中文名 	节点英文名 	节点状态 	创建时间 	修改时间 	操作-->
            <th>节点中文名</th>
            <th>节点英文名</th>
            <th>节点状态</th>
            <th>创建时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($node as $k1 => $v1) { ?>
            <tr>
                <th><?php echo $v1['node_name'] ?></th>
                <th><?php echo $v1['node_ename'] ?></th>
                <th><?php echo $v1['status'] ?></th>
                <th><?php echo $v1['create_time'] ?></th>
                <th><?php echo $v1['update_time'] ?></th>
                <th>
                    <button class="btn btn-primary btn-xs"> 修改</button>
                    <button class="btn btn-danger btn-xs">
                        删除
                    </button>
                </th>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . "/../public/footer.phtml"; ?>

