<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Honeypot check (if you have a hidden field like "website")
    if (!empty($_POST['website'])) {
        exit; // bot detected, silently stop
    }

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? 'New message from portfolio');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        die("Please fill in all required fields.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    $to = "rabbinur@proton.me"; 
    $emailSubject = "Portfolio Contact: " . $subject;

    $emailBody = "Name: $name\n";
    $emailBody .= "Email: $email\n";
    $emailBody .= "Subject: $subject\n\n";
    $emailBody .= "Message:\n$message\n";

    $headers = "From: no-reply@yourdomain.com\r\n"; // must be your domain
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    if (mail($to, $emailSubject, $emailBody, $headers)) {
        header("Location: thank-you.html"); // or back with a success message
        exit;
    } else {
        die("Something went wrong. Please try again later.");
    }
}
?>