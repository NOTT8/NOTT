<?php
// 1. จัดการ Headers เพื่อแก้ปัญหา CORS และ ngrok (สำคัญมากสำหรับการรันบน Web)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, ngrok-skip-browser-warning");
header("Content-Type: application/json; charset=UTF-8");

// 2. ตอบกลับ Pre-flight request สำหรับ Browser Preview ใน FlutLab
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// นำไฟล์เชื่อมต่อฐานข้อมูลมาใช้ (ตรวจสอบว่าชื่อไฟล์ db.php ถูกต้อง)
include 'db.php';

// 3. รับข้อมูล JSON จาก Flutter
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!empty($email) && !empty($password)) {
    // 4. ใช้ Prepared Statement เพื่อความปลอดภัยสูงสุด
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // ล็อกอินสำเร็จ
        echo json_encode(["status" => "success"]);
    } else {
        // ข้อมูลไม่ถูกต้อง
        echo json_encode([
            "status" => "fail", 
            "message" => "อีเมลหรือรหัสผ่านไม่ถูกต้อง"
        ]);
    }
    $stmt->close();
} else {
    // กรณีกรอกข้อมูลไม่ครบ
    echo json_encode([
        "status" => "error", 
        "message" => "กรุณากรอกข้อมูลให้ครบ"
    ]);
}

$conn->close();
?>