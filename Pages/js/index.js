import get_data from './ajax.js'

var table_data = get_data('table_content');
var data_count = table_data.length;
var img_size = 100;

if (data_count > 0) {
    for (var i = 0; i < data_count; i++) {
        const action = table_data[i]['action'];
        let color
        if (action == '新增'){
            color = 'green'
        }else if (action == '更新'){
            color = 'orange'
        }else if (action == '刪除'){
            color = 'red'
        }
        $('tbody').append(`
            <tr>
                <td>${table_data[i]['id']}</td>
                <td>
                    <img src='https://www.kishispo.net/upload/save_image/${table_data[i]['code']}.jpg' width='${img_size}' heigh='${img_size}'>
                </td>
                <td>${table_data[i]['eng_name']}</td>
                <td>${table_data[i]['code']}</td>
                <td>${table_data[i]['hope_price']}</td>
                <td>${table_data[i]['price']}</td>
                <td>${table_data[i]['point']}</td>
                <td>${table_data[i]['size']}</td>
                <td style="color: ${color};">${table_data[i]['action']}</td>
            </tr>
        `)
    }
} else {
    $('table').css('display', 'none');
    $('h3').css('display', 'block')
}

