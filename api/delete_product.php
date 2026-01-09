<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { exit; }

require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id)) {
    $id = $conn->real_escape_string($data->id);

    // ตรวจสอบชื่อตารางให้ตรงกับใน phpMyAdmin (ชื่อตารางคือ products)
    $sql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ไม่พบ ID ที่ต้องการลบ"]);
}
$conn->close();
?>