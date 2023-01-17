<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/api/config/config.php';

function getProfile($userid){
    DB::connectDB();
    $row=[];
    
    $sql="SELECT * FROM pooppay_users WHERE user_id=?";
    try{
        if($x=DB::$databasex->prepare($sql)){
            $x->bind_param("s",$userid);
            $x->execute();
            $result=$x->get_result();
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
            }
            $x->close();
        }
        DB::$databasex->close();
        
    }
    catch(Exception $e){}
    
    return $row;
}

//msg here is $sessionRes[msg]
if($msg==="perfect" && $auth==="perfect"){//if is in session and authenticated as current database occupant else LOG_OUT is passed as msg to response array, instructing app to navigate to login screen
    $row=getProfile($userid);
    $response["data"]=$row;
}

$response["msg"]=$msg;

echo json_encode($response);
?>