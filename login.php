<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/api/config/config.php';
//run this endpoint on open of login page, before login form is displayed
function loginUser($email,$password){
    $email=stripslashes(htmlspecialchars(trim(strtolower($email))));
    $password=stripslashes(htmlspecialchars(trim($password)));
    DB::connectDB();
    $loginRes=["msg"=>"Invalid login details"];
    
    $sql="SELECT user_id FROM pooppay_users WHERE email=? AND password=?";
    try{
        if($x=DB::$databasex->prepare($sql)){
            $x->bind_param("ss",$email,$password);
            $x->execute();
            $result=$x->get_result();
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $loginRes["userid"]=$row["user_id"];
                $loginRes["msg"]="perfect";
            }
            $x->close();
        }
        DB::$databasex->close();
        
    }
    catch(Exception $e){}
    
    return $loginRes;
}


if($msg==="perfect" && $auth==="perfect"){//if is in session and authenticated as current database occupant else LOG_OUT is passed as msg to response array, instructing app to navigate to login screen
    $response["msg"]=LOGGEDIN;//LOGGEDIN is passed to msg, instructing app to navigate to dashboard screen if you like
}else{
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $request_raw=file_get_contents('php://input');
        $request=json_decode($request_raw,true);
        $loginRes=loginUser($request['email'],$request['password']);
        if($loginRes["msg"]==="perfect"){//authentication passed so app should navigate to dashboard screen
            $_SESSION["userid"]=$loginRes["userid"];
        }
        $response["msg"]=$loginRes["msg"];//we are sending only a msg back, no data included
    }
}

//the app will anticipate two responses, 1)LOGGEDIN  then 2)perfect or invalid login details
echo json_encode($response);
?>