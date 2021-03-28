<?php

include 'classes/db-class.php';
include 'classes/tickets-class.php';



// Check if POST data exists (user submitted the form)

if(isset($_POST['Submit'])) {

    $title = $_POST['title'];
    $email = $_POST['email'];
    $msg = $_POST['msg'];

    date_default_timezone_set("Europe/Stockholm");
    $timeZoneSet = date("Y-m-d h:i:sa");

    if (empty($_POST['title']) || empty($_POST['email']) || empty($_POST['msg'])) {
        $msg = 'Please complete the form!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $msg = 'Please provide a valid email address!';
    } else {
        $newTicket = new Ticket();
        $sql = $newTicket->createNewTicket($title, $email, $msg, $timeZoneSet);
    }
}

echo '<div class="content create">';

echo '<h2>Create a new ticket</h2>';

?>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>
<form action="" method="post">

    <label for="title">Title</label>
    <input type="text" name="title" placeholder="Title" id="title" required>
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Email" id="email" required>
    <label for="msg">Message</label>
    <textarea name="msg" placeholder="Enter your message here..." id="msg" required></textarea>
    <div class="btns">
    <input type="submit" value="Create" name="Submit" class="btns">
    </div>
</form>
<div class="btns">
    <?php
    echo '<a href="index.php" class="btn">Go Back</a>';
    ?>
</div>
</body>
</html>



