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

// POST data
$firstname = $conn->real_escape_string($_POST['firstname']);
$lastname = $conn->real_escape_string($_POST['lastname']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$address = $conn->real_escape_string($_POST['address']);
$message = $conn->real_escape_string($_POST['message']);

// Check for duplicate email
$checkEmail = "SELECT id FROM contact_form WHERE email = '$email'";
$result = $conn->query($checkEmail);

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'warning', 'message' => 'Email already exists.']);
    exit;
}

// Insert into database
$sql = "INSERT INTO contact_form (firstname, lastname, email, phone, address, message)
        VALUES ('$firstname', '$lastname', '$email', '$phone', '$address', '$message')";

if ($conn->query($sql)) {
    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'punitha@boscosofttech.com';
        $mail->Password = 'skww qihs pxav brkl'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('higrade@boscosofttech.com', 'HiGrade Contact');
        $mail->addAddress('binfo@boscosofttech.com');
        $mail->addAddress('higrade@boscosofttech.com');
        $mail->addAddress('joeni@boscosofttech.com');

        $mail->isHTML(true);
        $mail->Subject = "Higrade Demo Submission";
        $mail->Body = "
            <strong>First Name:</strong> $firstname<br>
            <strong>Last Name:</strong> $lastname<br>
            <strong>Email:</strong> $email<br>
            <strong>Phone:</strong> $phone<br>
            <strong>Address:</strong> $address<br>
            <strong>Message:</strong> $message
        ";

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
