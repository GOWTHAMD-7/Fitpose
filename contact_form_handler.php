<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // Redirect to the Thank You page
    header('Location: thank_you.php');
    exit();
}
?>
