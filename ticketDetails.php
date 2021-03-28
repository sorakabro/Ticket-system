<?php

include 'classes/db-class.php';
include 'classes/tickets-class.php';

$id = $_GET['id'];

if (!isset($id)) {
    exit('No ID specified!');
}

// Update status
$statusChange = $_GET['status'];

$postedComments = $_POST['msg'];

// Get Date
date_default_timezone_set("Europe/Stockholm");
$timeZoneSet = date("Y-m-d h:i:sa");

$tickets = new Ticket();

// Change Ticketstatus
$ticketStatus = $tickets->changeTicketStatus($id, $statusChange);

// Delete ticket
$tickets->deleteTicket($id,$statusChange);

// Create TicketComments
$ticketComments = $tickets->ticketComments($id, $postedComments, $timeZoneSet);

// Get TicketComments
$comments = $tickets->getComments($id);


// Get SpecificTicket
$ticket = $tickets->getOneTicket($id);


foreach($ticket as $ticketInfo){
  $title =  $ticketInfo['title'];
  $msg = $ticketInfo['msg'];
  $date = $ticketInfo['created'];
  $status = $ticketInfo['status'];
}

?>

    <head>
        <meta charset="utf-8">
        <title>Ticket System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="includes/style.css">
    </head>
<div class="content view">

	<h2><?=htmlspecialchars($title, ENT_QUOTES)?> <span class="<?=$status?>">(<?=$status?>)</span></h2>

    <div class="ticket">
        <p class="created"><?=date('F dS, G:ia', strtotime($date))?></p>
        <p class="msg"><?=nl2br(htmlspecialchars($msg, ENT_QUOTES))?></p>
    </div>

    <div class="btns">
        <a href="ticketDetails.php?id=<?=$id?>&status=closed" class="btn red">Close</a>
        <a href="ticketDetails.php?id=<?=$id?>&status=reopen" class="btn">Reopen</a>
        <a href="edit-ticket.php?id=<?=$id?>&ticketHandler=edit" class="btn">Edit</a>
        <a href="ticketDetails.php?id=<?=$id?>&status=delete" class="btn red">Delete</a>

    </div>

    <div class="comments">
        <?php foreach($comments as $comment): ?>
        <div class="comment">
            <div>
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <p>
                <span><?=date('F dS, G:ia', strtotime($comment['created']))?></span>
                <?=nl2br(htmlspecialchars($comment['msg'], ENT_QUOTES))?>
            </p>
        </div>
        <?php endforeach; ?>
        <form action="" method="post">
            <textarea name="msg" placeholder="Enter your comment..." required></textarea>
            <input type="submit" value="Post Comment">
        </form>
        <div class="btns">
        <?php
        echo '<a href="index.php" class="btn">Go Back</a>';
        ?>
        </div>
    </div>

</div>



<?php


if (!$ticket) {
    exit('Invalid ticket ID!');
}