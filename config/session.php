<?php
session_start();
define("LOGGEDIN","LOGGEDIN");
define("LOGGEDOUT","LOGGEDOUT");
function inSession(){
    $sessionRes=["msg"=>LOGGEDOUT,"userid"=>""];//if not in session, meaning user is logged out or not even logged in, hence go to login screen
    if(isset($_SESSION["userid"])){//if userid in session
        $sessionRes["msg"]="perfect";//respond perfect
        $sessionRes["userid"]=$_SESSION['userid'];//provide userid
    }
    return $sessionRes;
}



?>