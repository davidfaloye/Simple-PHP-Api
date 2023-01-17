<?php
date_default_timezone_set('Africa/Lagos');
class DB{
    const HOSTNAME="localhost";
    const HOSTUSER="bulbflgm_phlox";
    const HOSTPASSWORD="h?{6ry?@2w57";
    const HOSTDB="bulbflgm_cloud";
    const DENIED="DENIED";
    public static $databasex;//i need to call and use this guy in a function that doesnt inherit this DB class so i have to make it static
                            //generally, static is used when you dont want to have to instantiate a class before accessing its content
    
    public static function connectDB(){//this function is static because i don't want to instantiate this class when i need to call this function
        self::$databasex= new mysqli(self::HOSTNAME, self::HOSTUSER, self::HOSTPASSWORD, self::HOSTDB);//constant and static variables are called using self:: not $this->
                                                                                                    //for constant the $ sign is absent while for static the $ sign must be present
        if (self::$databasex->connect_error) {die("Connection failed: " . self::$databasex->connect_error);}
    }
    
    public static function authenticateUser($userid){
        self::connectDB();
        $msg=self::DENIED;//set default response for this function to be denied
        
        $sql="SELECT id FROM pooppay_users WHERE user_id=?";
        try{
            if($x=self::$databasex->prepare($sql)){
                $x->bind_param("s",$userid);
                $x->execute();
                $result=$x->get_result();
                if($result->num_rows>0){
                    $msg="perfect";
                }
                $x->close();
            }
            self::$databasex->close();
        }
        catch(Exception $e){}
        
        return $msg;
    }
    

}




