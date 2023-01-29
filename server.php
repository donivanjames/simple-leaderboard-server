<?php
    header("Content-type:application/json");


    $db_host="localhost";
    $db_user="root";
    $db_password="";

    $lnk=mysqli_connect($db_host, $db_user, $db_password);
    if(!$lnk) die("No connecty, something wrong: server.php line 8");


    mysqli_select_db($lnk, "bns-leaderboard-1") or die ("Failed to select DB");


    // if info is recieved, send to database, else: pull scores from database
    if(isset($_GET["info"])) {
        $info=json_decode($_GET["info"], true);
        if(addScore($info, $lnk)) echo "Score Inserted!";
        else echo "Score Insertion Failed";
    } else {
        $result = getScores($lnk);
    
        echo json_encode($result);
    }

    // Add Score
    function addScore($info, $lnk) {
        $query="INSERT INTO scores (Name, Score) VALUES".
               "('".$info["name"]."', '".$info["score"]."')";
        
        $rs=mysqli_query($lnk, $query);
        if(!$rs) {
            return false;
        }
        return true;
    }

    // Get Scores
    function getScores($lnk) {
        $query="SELECT * FROM scores ORDER BY score DESC";

        $rs=mysqli_query($lnk, $query);
        
        $results=array();
        if(mysqli_num_rows($rs) > 0) {
            while($row=mysqli_fetch_assoc($rs)) {
                array_push($results, $row);
            }
        }
        return $results;
    }
?>