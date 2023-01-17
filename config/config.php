<?php
require_once 'session.php';
require_once 'connectdb.php';
$response=["msg"=>"","data"=>[]];
$sessionRes=inSession();
$msg=$sessionRes["msg"];//at this point, depending of whether in session or not, msg is either perfect or log_out
$userid=$sessionRes["userid"];//provided accurately or is empty
$auth=DB::authenticateUser($userid);//auth is perfect if userid was provided or else it's DENIED
?>