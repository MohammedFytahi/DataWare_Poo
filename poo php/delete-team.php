<?php

include "Scrum.php";

// Check if the team ID is provided in the URL parameters
if (isset($_GET['id'])) {
    $teamId = $_GET['id'];

    $database = new PDO("mysql:host=localhost;dbname=dataware", "root", "");
    $scrumMaster = new Scrum(null, null, null, null, null, null, $database);

    $message = $scrumMaster->deleteTeam($teamId);

    echo $message;
} else {
    echo "Team ID not provided.";
}
?>
