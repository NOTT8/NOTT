<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id = $data['id'] ?? '';
$name = $data['name'] ?? '';
$price = $data['price'] ?? '';
$qty = $data['qty'] ?? '';
$image = $data['image'] ?? ''; // ✅ รับค่ารูป

if (!empty($id)) {
    // อัปเดต 4 คอลัมน์ (name, price, qty, image) โดยใช้ id เป็นตัวกำหนด
    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, qty=?, image=? WHERE id=?");
    $stmt->bind_param("ssisi", $name, $price, $qty, $image, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "ID is missing"]);
}
$conn->close();
?>