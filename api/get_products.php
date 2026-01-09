<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

// แนะนำให้เรียงจาก id ล่าสุดขึ้นก่อน (ORDER BY id DESC)
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
echo json_encode($products);
$conn->close();
?>