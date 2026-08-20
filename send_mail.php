<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['website'])) {
        exit;
    }

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? 'New message from portfolio');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Please fill in all required fields."]);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email address."]);
        exit;
    }

    $to = "rabbinur@proton.me";
    $emailSubject = "Portfolio Contact: " . $subject;

    $emailBody = "Name: $name\n";
    $emailBody .= "Email: $email\n";
    $emailBody .= "Subject: $subject\n\n";
    $emailBody .= "Message:\n$message\n";

    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (mail($to, $emailSubject, $emailBody, $headers)) {
        echo json_encode(["status" => "success", "message" => "Your message has been sent. Thank you!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again later."]);
    }
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid request."]);
