<?php

include "classes/db-class.php";
include "classes/tickets-class.php";



?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ticket System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="includes/style.css">
</head>

<body>

<?php

$filterStatus = $_GET['filter'];

$tickets = new Ticket();


// Filter function
if (isset($filterStatus) && in_array($filterStatus, array('open', 'closed', 'reopen'))) {
    $tickets = $tickets->getFilterTickets($filterStatus);
}else {
    $tickets = $tickets->getAllTickets();
}
?>

<div class="content home">

	<h2>Ticket system</h2>

	<p>Here you can see all the tickets.</p>

	<div class="btns">
		<a href="create-ticket.php" class="btn">Create Ticket</a>

	</div>
    <div class="btns">
        <a href="index.php?filter=all" class="btn">All</a>
        <a href="index.php?filter=open" class="btn">Open</a>
        <a href="index.php?filter=reopen" class="btn">Reopen</a>
        <a href="index.php?filter=closed" class="btn red">Closed</a>
    </div>
	<div class="tickets-list">
		<?php foreach ($tickets as $ticket): ?>
<a href="ticketDetails.php?id=<?=$ticket['id']?>" class="ticket">
			<span class="con">
				<?php if ($ticket['status'] == 'open'): ?>
                    <i class="open-status">Open</i>
                <?php elseif ($ticket['status'] == 'reopen'): ?>
                    <i class="reopen-status">Reopen</i>
                <?php elseif ($ticket['status'] == 'closed'): ?>
                    <i class="closed-status">Closed</i>
                <?php endif; ?>
			</span>
    <span class="con">
				<span class="title"><?=htmlspecialchars($ticket['title'], ENT_QUOTES)?></span>
				<span class="msg"><?=htmlspecialchars($ticket['msg'], ENT_QUOTES)?></span>
			</span>
    <span class="con created"><?=date('F dS, G:ia', strtotime($ticket['created']))?></span>
</a>
<?php endforeach; ?>
</div>

</div>

</body>
</html>
