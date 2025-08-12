<?php
header('Content-Type: application/json');

// DB connection
$conn = new mysqli("localhost", "root", "", "higrade25");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$email = trim($conn->real_escape_string($_POST['email'] ?? ''));

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address']);
    exit;
}

// Check for duplicates
$check = $conn->prepare("SELECT id FROM newsletter WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['status' => 'warning', 'message' => 'Email already Submitted']);
    exit;
}

// Insert email
$stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Thank you for Submitting!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database insert failed']);
}

$conn->close();
?>
