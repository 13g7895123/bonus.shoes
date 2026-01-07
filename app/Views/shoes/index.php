<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新資料 - Bonus Shoes</title>

    <!-- 引入Tailwind -->
    <link rel="stylesheet" href="<?= base_url('dist/output.css') ?>">
    <!-- 引入jQuery -->
    <script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body class='max-h-[80vh]' style="max-width: 1280px; margin-left:auto; margin-right:auto;">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center">鞋子資料管理系統</h1>

        <table class="table-class w-full">
            <thead>
                <tr>
                    <th class="th-class">ID</th>
                    <th class="th-class">圖片</th>
                    <th class="th-class">英文名稱</th>
                    <th class="th-class">商品代碼</th>
                    <th class="th-class">希望價格</th>
                    <th class="th-class">價格</th>
                    <th class="th-class">點數</th>
                    <th class="th-class">尺寸</th>
                    <th class="th-class">動作</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <h3 class='hidden text-center text-xl mt-10'>資料沒有更新</h3>
    </div>

    <script>
        // API 端點配置
        const API_BASE_URL = '<?= base_url('api/shoes') ?>';
        const IMG_SIZE = 100;

        // 載入資料
        async function loadTableData() {
            try {
                const response = await fetch(API_BASE_URL);
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    renderTable(result.data);
                } else {
                    showNoDataMessage();
                }
            } catch (error) {
                console.error('載入資料失敗:', error);
                showNoDataMessage();
            }
        }

        // 渲染表格
        function renderTable(data) {
            const tbody = $('tbody');
            tbody.empty();

            data.forEach(item => {
                const color = getActionColor(item.action);
                const imageUrl = `https://www.kishispo.net/upload/save_image/${item.code}.jpg`;

                tbody.append(`
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">${item.id}</td>
                        <td class="border px-4 py-2">
                            <img src="${imageUrl}" 
                                 width="${IMG_SIZE}" 
                                 height="${IMG_SIZE}"
                                 alt="${item.eng_name}"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'100\\' height=\\'100\\'%3E%3Crect fill=\\'%23ddd\\' width=\\'100\\' height=\\'100\\'/%3E%3Ctext fill=\\'%23999\\' x=\\'50%25\\' y=\\'50%25\\' text-anchor=\\'middle\\' dy=\\'.3em\\'%3E無圖片%3C/text%3E%3C/svg%3E'">
                        </td>
                        <td class="border px-4 py-2">${item.eng_name || '-'}</td>
                        <td class="border px-4 py-2">${item.code || '-'}</td>
                        <td class="border px-4 py-2">${item.hope_price || '-'}</td>
                        <td class="border px-4 py-2">${item.price || '-'}</td>
                        <td class="border px-4 py-2">${item.point || '-'}</td>
                        <td class="border px-4 py-2">${item.size || '-'}</td>
                        <td class="border px-4 py-2" style="color: ${color}; font-weight: bold;">
                            ${item.action || '-'}
                        </td>
                    </tr>
                `);
            });
        }

        // 取得動作顏色
        function getActionColor(action) {
            switch (action) {
                case '新增':
                    return 'green';
                case '更新':
                    return 'orange';
                case '刪除':
                    return 'red';
                default:
                    return 'black';
            }
        }

        // 顯示無資料訊息
        function showNoDataMessage() {
            $('table').css('display', 'none');
            $('h3').css('display', 'block');
        }

        // 頁面載入時執行
        $(document).ready(function() {
            loadTableData();
        });
    </script>
</body>

</html>