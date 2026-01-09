<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { exit; }

require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if($data && !empty($data->email) && !empty($data->password)) {
    $email = $data->email;
    $password = $data->password; // ในการใช้งานจริงควรใช้ password_hash

    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

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