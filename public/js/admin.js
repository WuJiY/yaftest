/**
 * Created by dell on 15-10-28.
 */

function ajax_sub(url, data) {
    $.ajax({
        "url": url,
        "type": "post",
        "dataType": "json",
        success: function (response) {
            if (response.error == 100) {
                alert(response.msg);
                return false;
            } else {
                alert(response.msg);
            }
        }
    });
}