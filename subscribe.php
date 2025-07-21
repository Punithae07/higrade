<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php'; // Make sure you ran: composer require phpmailer/phpmailer

// DB connection
$host = "localhost";
$user = "root";
$pass = ""; // Your DB password
$db   = "acmeerp";

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Validate and sanitize email
if (!isset($_POST['email'])) {
    echo "❌ Email is required.";
    exit;
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Invalid email address.";
    exit;
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Insert new email
    $insert = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
    $insert->bind_param("s", $email);

    if ($insert->execute()) {
        // Send welcome email
        $mail = new PHPMailer(true);
        try {
            // SMTP config
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Use smtp.gmail.com for Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'punitha@boscosofttech.com'; // Your Gmail or SMTP email
            $mail->Password   = 'yimp xbat fdol udqj'; // App password (not Gmail password!)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Email content
            $mail->setFrom('punitha@boscosofttech.com', 'acmeerp.org');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = '🎉 Welcome to Daily Updates!';
            $mail->Body    = "
                Hi there!<br><br>
                Thanks for subscribing to our daily updates.<br>
                Stay tuned for awesome content every day.<br><br>
                Best,<br>Your Website Team
            ";

//             $mail->send();
//             echo "✅ Thank you for subscribing! Please check your email.";
//         } catch (Exception $e) {
//             echo "✅ Subscribed successfully, but failed to send welcome email.";
//         }
//     } else {
//         echo "❌ Failed to subscribe. Please try again later.";
//     }
// } else {
//     echo "⚠️ This email is already subscribed.";
// }

$mail->send();
        header("Location: index.php?status=success");
    } catch (Exception $e) {
        header("Location: index.php?status=mail_failed");
    }
} else {
    header("Location: index.php?status=error");
}
}

// Close DB
$conn->close();
?>
