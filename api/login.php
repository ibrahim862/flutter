<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "user_management");
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($hashedPassword);
$stmt->fetch();

if ($hashedPassword && password_verify($password, $hashedPassword)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
}

$stmt->close();
$conn->close();
?>
