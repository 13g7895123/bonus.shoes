const get_data = (action) => {
    var return_data;
    $.ajax({
        type: "POST",
        url: ajax_url + '?action=' + action,
        dataType: "JSON",
        async: false,
        success: function (data) {
            if (data.success) {
                return_data = data.data;
            } else {
                alert(data.msg);
            }
        }, error: function () {
            alert("獲取資料失敗");
        }
    });

    return return_data;
}

export default get_data;