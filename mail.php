<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get form values
$firstname = $_POST['name'] ?? '';
$lastname  = $_POST['orgname'] ?? '';
$email     = $_POST['email'] ?? '';
$number    = $_POST['number'] ?? '';
$address   = $_POST['address'] ?? '';
$message   = $_POST['message'] ?? '';

// Basic validation
if (empty($firstname) || empty($email)) {
    echo '<div class="form-messages error" style="color: red; font-weight: bold;">Name and Email are required fields.</div>';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="form-messages error" style="color: red; font-weight: bold;">Please enter a valid email address.</div>';
    exit;
}

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

    // Check for duplicate email
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contact_form WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        echo '<div class="form-messages error" style="color: red; font-weight: bold;">This email has already been submitted.</div>';
        exit;
    }

    // Insert into database
    $insert = $pdo->prepare("INSERT INTO contact_form (firstname, lastname, email, phone, address, message) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->execute([$firstname, $lastname, $email, $number, $address, $message]);

    // Send mail using PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'punitha@boscosofttech.com'; // your email
    $mail->Password   = 'yimp xbat fdol udqj'; // your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('punitha@boscosofttech.com', 'Website Contact');
    $mail->addAddress('punithatha07@gmail.com'); // receiver email

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

} catch (Exception $e) {
    echo '<div class="form-messages error" style="color: red; font-weight: bold;">Mailer Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
} catch (PDOException $e) {
    echo '<div class="form-messages error" style="color: red; font-weight: bold;">Database Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
?>
