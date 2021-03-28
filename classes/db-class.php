<?php

// Create DB connection
class DB {
   private $host = "shareddb-b.hosting.stackcp.net";
    private $user = "Ticket-system-exakta-3533d523";
    private $password = "v79g87tnnb";
    private $dbName = "Ticket-system-exakta-3533d523";

   protected function connectDb() {

       $conn = new mysqli($this->host, $this->user, $this->password, $this->dbName);

       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }
       return $conn;
       }
}