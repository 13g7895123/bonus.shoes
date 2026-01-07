<?php

// echo '123';

include_once(__DIR__ . '/../../__Class/ClassLoad.php');

if(isset($_GET['action'])){
    switch ($_GET['action']) {
        case 'table_content':

            MYPDO::$table = 'shoes_show_inf';
            // MYPDO::$table = 'shoes_inf';
            $results = MYPDO::select();

            $data['success'] = true;
            $data['data'] = $results;

            echo json_encode($data);
            break;
    }
}