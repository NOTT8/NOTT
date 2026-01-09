<?php
$conn = new mysqli("localhost", "root", "", "my_stock_db");
if ($conn->connect_error) { die("Error"); }
// ห้ามมี echo "Connected"; หรือข้อความใดๆ ในนี้เด็ดขาด
?>