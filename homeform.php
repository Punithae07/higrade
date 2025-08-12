<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

// DB connection
$conn = new mysqli("localhost", "root", "", "higrade25");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Sanitize & fetch inputs
$name = trim($conn->real_escape_string($_POST['name'] ?? ''));
$email     = trim($conn->real_escape_string($_POST['email'] ?? ''));
$phone     = trim($conn->real_escape_string($_POST['phone'] ?? ''));
$message   = trim($conn->real_escape_string($_POST['message'] ?? ''));

// Validate
if (strlen($name) < 3) {
    echo json_encode(['status' => 'error', 'message' => 'Name must be at least 3 characters']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}
if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
    echo json_encode(['status' => 'error', 'message' => 'Phone must be 10–15 digits']);
    exit;
}
if (strlen($message) < 5) {
    echo json_encode(['status' => 'error', 'message' => 'Message is too short']);
    exit;
}

// Check for duplicate email
$checkEmail = $conn->prepare("SELECT id FROM home_form WHERE email = ?");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$checkEmail->store_result();

if ($checkEmail->num_rows > 0) {
    echo json_encode(['status' => 'warning', 'message' => 'Email already exists']);
    exit;
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO home_form (name, email, phone, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $phone, $message);

if ($stmt->execute()) {
    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'punitha@boscosofttech.com';
        $mail->Password   = 'skww qihs pxav brkl'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('punitha@boscosofttech.com', 'HiGrade Contact');
        $mail->addAddress('punitha@boscosofttech.com'); // Recipient

        $mail->isHTML(true);
        $mail->Subject = "HiGrade Contact Form Submission";
        $mail->Body    = "
            <strong>Name:</strong> {$name}<br>
            <strong>Email:</strong> {$email}<br>
            <strong>Phone:</strong> {$phone}<br>
            <strong>Message:</strong><br>" . nl2br($message);

        $mail->send();

        echo json_encode(['status' => 'success', 'message' => 'Thank you! Your message has been sent.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Mail Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database insert failed']);
}

$conn->close();
?>
