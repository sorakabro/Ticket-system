<?php

class Ticket extends DB
{

    public function getAllTickets()
    {
        $conn = $this->connectDb();
        $sql = "SELECT * FROM tickets ORDER BY created DESC";
        $result = $conn->query($sql);
        $result_Rows = $result->num_rows;

        if ($result_Rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getFilterTickets($filterStatus){

        $conn = $this->connectDb();
        if (isset($filterStatus) && in_array($filterStatus, array('open', 'closed', 'reopen'))) {
            $sql = "SELECT * FROM tickets WHERE tickets. status = '$filterStatus' ORDER BY created DESC";
            $result = $conn->query($sql);
            $result_Rows = $result->num_rows;

            if ($result_Rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
        }
    }

    public function getOneTicket($id)
    {
        $conn = $this->connectDb();
        $sql = "SELECT * FROM tickets WHERE id=$id";
        $query = $conn->query($sql);

        $result_Rows = $query->num_rows;

        if ($result_Rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function getComments($id){
        $conn = $this->connectDb();
        $sql = "SELECT * FROM `ticket-comments` WHERE ticket_id = '$id'";
        $result = $conn->query($sql);
        $result_Rows = $result->num_rows;

        while ($result_Rows = $result->fetch_assoc()){
            $comments[] = $result_Rows;
        }

        return $comments;

    }

    public function prepareForSql($args){
        $conn = $this->connectDb();
        $Sqldata =  $conn->real_escape_string($args);
        return $Sqldata;
    }

    public function createNewTicket($title, $email, $msg, $timeZoneSet)
    {

        $conn = $this->connectDb();

        // Clean up the input variables to prepare for insertion to database.
        $valTitle = $this->prepareForSql($title);
        $valEmail = $this->prepareForSql($email);
        $valMsg = $this->prepareForSql($msg);
        $valTimeZone = $this->prepareForSql($timeZoneSet);
        $sql = "INSERT INTO `tickets` (`id`, `title`, `msg`, `email`, `created`, `status`) VALUES (NULL, '$valTitle', '$valMsg', '$valEmail', '$valTimeZone', 'open')";
        $query = $conn->query($sql);

        if ($query === TRUE) {
            echo "New ticket created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

    }



    public function changeTicketStatus($id,$statusChange) {

        $conn = $this->connectDb();
        if (isset($statusChange) && in_array($statusChange, array('open', 'closed', 'reopen'))) {

            // Clean up the input variables to prepare for insertion to database.
            $valId = $this->prepareForSql($id);
            $valStatusChange = $this->prepareForSql($statusChange);
            $sql= "UPDATE `tickets` SET `status` = '$valStatusChange' WHERE `tickets`.`id` = '$valId'";
            $query = $conn->query($sql);
            if ($query === TRUE) {
                echo "Status updated to: $statusChange";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

          echo  '<a href="ticketDetails.php?id='.$id.'" class="btn" style=" 
            
            display: inline-block;
            text-decoration: none;
            background-color: #38b673;
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            color: #FFFFFF;
            padding: 10px 15px;
            margin: 15px 10px 15px 15px;
            ">Go Back</a>';

            exit;
        }
    }

    public function ticketComments($id, $postedComments, $timeZoneSet){

        // Check if the comment form has been submitted
        if (isset($postedComments) && !empty($postedComments)) {

            // Insert the new comment into the "tickets_comments" table
            $conn = $this->connectDb();

            $valId = $this->prepareForSql($id);
            $valPostedComments = $this->prepareForSql($postedComments);
            $valTimeZoneSet = $this->prepareForSql($timeZoneSet);

            $sql = "INSERT INTO `ticket-comments` (`ticket_id`, `msg`, `created`) VALUES ('$valId', '$valPostedComments', '$valTimeZoneSet')";

            $query = $conn->query($sql);

            if ($query === TRUE) {
                echo "Comment added";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

            echo  '<a href="ticketDetails.php?id='.$id.'" class="btn" style=" 
            
            display: inline-block;
            text-decoration: none;
            background-color: #38b673;
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            color: #FFFFFF;
            padding: 10px 15px;
            margin: 15px 10px 15px 15px;
            ">Go Back</a>';

            exit;
        }

    }

    public function editTicket($id, $title, $email, $msg, $timeZoneSet, $ticketHandler)
    {

        if (isset($ticketHandler) && in_array($ticketHandler, array('edit'))) {

            $conn = $this->connectDb();
            $valId = $this->prepareForSql($id);
            $valTitle = $this->prepareForSql($title);
            $valEmail = $this->prepareForSql($email);
            $valMsg = $this->prepareForSql($msg);
            $valTimeZone = $this->prepareForSql($timeZoneSet);
            $sql = "UPDATE `tickets` SET `title` = '$valTitle', `msg` = '$valMsg', `email` = '$valEmail', `created` = '$valTimeZone' WHERE `tickets`.`id` = '$valId'";
            $query = $conn->query($sql);

            if ($query === TRUE) {
                echo "Ticket Updated!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

            echo '<a href="ticketDetails.php?id=' . $id . '" class="btn" style=" 
            
            display: inline-block;
            text-decoration: none;
            background-color: #38b673;
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            color: #FFFFFF;
            padding: 10px 15px;
            margin: 15px 10px 15px 15px;
            ">Go Back</a>';

            exit;
        }
    }

    public function deleteTicket($id,$statusChange) {
        $conn = $this->connectDb();
        $valId = $this->prepareForSql($id);
        if (isset($statusChange) && in_array($statusChange, array('delete'))) {
            $sql = "DELETE FROM `tickets` WHERE `tickets`.`id` = '$valId'";

            $query = $conn->query($sql);
            if ($query === TRUE) {
                echo "Ticket Deleted!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();

            echo '<a href="index.php" class="btn" style=" 
            
            display: inline-block;
            text-decoration: none;
            background-color: #38b673;
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            color: #FFFFFF;
            padding: 10px 15px;
            margin: 15px 10px 15px 15px;
            ">Go Back</a>';

            exit;
        }
        }


}