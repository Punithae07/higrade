<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$firstname = $_POST['name'] ?? '';
$lastname  = $_POST['orgname'] ?? '';
$email     = $_POST['email'] ?? '';
$number    = $_POST['number'] ?? '';
$address   = $_POST['address'] ?? '';
$message   = $_POST['message'] ?? '';

// DB Connection
$host = 'localhost';
$db   = 'higrade25';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Duplicate check
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_form WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        echo '<div class="form-messages error" style="color: red; font-weight: bold;">This email has already been submitted.</div>';
        exit;
    }

    // Insert into DB
    $insert = $pdo->prepare("INSERT INTO contact_form (firstname, lastname, email, phone, address, message) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->execute([$firstname, $lastname, $email, $number, $address, $message]);

    // Send mail
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'punitha@boscosofttech.com';
    $mail->Password   = 'yimp xbat fdol udqj'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('punitha@boscosofttech.com', 'Website Contact');
    $mail->addAddress('punithatha07@gmail.com');

    $mail->isHTML(false);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body    =
        "Name: $firstname\n" .
        "Organization: $lastname\n" .
        "Email: $email\n" .
        "Phone: $number\n" .
        "Address: $address\n" .
        "Message: $message";

    $mail->send();
    echo '<div class="form-messages success" style="color: green; font-weight: bold;">Thank you! Your message has been sent successfully.</div>';
}
 catch (Exception $e) {
    echo '<div class="form-messages error" style="color: red; font-weight: bold;">Mailer Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
