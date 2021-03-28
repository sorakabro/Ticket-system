<?php

include 'classes/db-class.php';
include 'classes/tickets-class.php';

$id = $_GET['id'];

//Edit Ticket

$tickets = new Ticket();

// Edit handler

$ticketHandler = $_GET['ticketHandler'];

$ticketInfo = $tickets->getOneTicket($id);

foreach ($ticketInfo as $ticket){
    $title = $ticket['title'];
    $email = $ticket['email'];
    $msg = $ticket['msg'];
}

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

        $sql = $tickets->editTicket($id, $title, $email, $msg, $timeZoneSet, $ticketHandler);
    }
}





echo '<div class="content create">';

echo '<h2>Update ticket</h2>';

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
    <input type="text" name="title" placeholder="<?php echo $title; ?>" id="title" required>
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="<?php echo $email; ?>" id="email" required>
    <label for="msg">Message</label>
    <textarea name="msg" placeholder="<?php echo $msg; ?>" id="msg" required></textarea>
    <div class="btns">
        <input type="submit" value="Update" name="Submit" class="btns">
    </div>
</form>
<div class="btns">
    <?php
echo '<a href="ticketDetails.php?id='.$id.'" class="btn">Go Back</a>';
    ?>
</div>
</body>
</html>