<?php
/*http://localhost/練習/html/第十章/10-6.html*/
    date_default_timezone_set('Asia/Tokyo');
    $start = $_GET['start'];
    $end = $_GET['end'];
    $obj = array();
    foreach(file('holiday.csv') as $line){
        list($date, $name) = explode(',', trim($line));
        $date = date('Y-m-d', strtotime($date));
        if($date >= $start && $date <= $end){
            $obj += array($date => $name);
        }
    }
    print json_encode($obj, JSON_UNESCAPED_UNICODE);
?>
