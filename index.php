<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新資料</title>

    <!-- 引入Tailwind -->
    <link rel="stylesheet" href="./dist/output.css" > 
    <!-- 引入jQuery -->
    <script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<body class='max-h-[80vh]' style="max-width: 1280px; margin-left:auto; margin-right:auto;">
    <table class="table-class">
        <thead>
            <tr>
                <th class="th-class">id</th>
                <th class="th-class">images</th>
                <th class="th-class">eng_name</th>
                <th class="th-class">code</th>
                <th class="th-class">hope_price</th>
                <th class="th-class">price</th>
                <th class="th-class">point</th>
                <th class="th-class">size</th>
                <th class="th-class">action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <h3 class='hidden'>資料沒有更新</h3>
    <script type='module' src='./Pages/js/index.js'></script>
    <script>const ajax_url = 'Pages/ajax/index.php';</script>
</body>
</html>