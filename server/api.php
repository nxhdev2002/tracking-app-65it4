<?php

$time = $_GET['time'];
$event = intval($_GET['event']);

// 1 = số lần chuyển tab và thời gian
// 2 = số lần không thấy khuôn mặt và thời gian


if ($event == 1) {
    $data = "Chuyen tab luc: $time \n";
} elseif ($event == 2) {
    $data = "Khong thay khuon mat luc: $time \n";
}
file_put_contents("log.txt", $data, FILE_APPEND);