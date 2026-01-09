<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { exit; }

require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if($data && !empty($data->name) && !empty($data->price)) {
    $name = $conn->real_escape_string($data->name);
    $price = $conn->real_escape_string($data->price);
    $qty = $conn->real_escape_string($data->qty);

    // ตรวจสอบชื่อคอลัมน์ในฐานข้อมูล (ต้องตรงกับ name, price, qty)
    $sql = "INSERT INTO products (name, price, qty) VALUES ('$name', '$price', '$qty')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ข้อมูลไม่ครบ"]);
}
$conn->close();
?>