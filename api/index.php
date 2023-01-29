<?php
    header("Content-type:application/json");
    echo "here"

    //please dont hack me this is just for fun

    //$db_connection = pg_connect("host=localhost dbname=dbname user=username password=password");

    $server="elephantsql.com";
    $user="pausapcx";
    $password="vxSa5l3ZK_F2lrlMGhyt0XBlYbX7hfWY";
    $name="pausapcx"


    $lnk=mysqli_connect($server, $user, $password, $name); // , $db_host, $db_user, $db_password
    if(!$lnk) die("No connecty");
    else echo "We've got something"

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
