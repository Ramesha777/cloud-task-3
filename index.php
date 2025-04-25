<?php
// Define variables and set to empty values
$name = $email = $message = "";
$nameErr = $emailErr = $messageErr = "";
$successMsg = "";

// When the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $valid = false;
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $valid = false;
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $valid = false;
    } else {
        $email = htmlspecialchars($_POST["email"]);
    }

    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
        $valid = false;
    } else {
        $message = htmlspecialchars($_POST["message"]);
    }

    // If everything is valid, send email
    if ($valid) {
        $to = "your@email.com";  // Replace with your email
        $subject = "New message from contact form";
        $body = "Name: $name\nEmail: $email\nMessage:\n$message";

        if (mail($to, $subject, $body)) {
            $successMsg = "Message sent successfully!";
            $name = $email = $message = ""; // clear inputs
        } else {
            $successMsg = "Sorry, something went wrong.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Contact Form</title>
</head>
<body>
    <h2>Contact Us</h2>
    <?php if ($successMsg) echo "<p><strong>$successMsg</strong></p>"; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Name: <br>
        <input type="text" name="name" value="<?php echo $name; ?>">
        <span style="color:red;">* <?php echo $nameErr; ?></span><br><br>

        Email: <br>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <span style="color:red;">* <?php echo $emailErr; ?></span><br><br>

        Message: <br>
        <textarea name="message" rows="5" cols="40"><?php echo $message; ?></textarea>
        <span style="color:red;">* <?php echo $messageErr; ?></span><br><br>

        <input type="submit" value="Send">
    </form>
</body>
</html>
