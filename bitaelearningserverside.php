<?php 
require( __DIR__ . "/db/db.php");
date_default_timezone_set("Asia/Dhaka");
if($_SERVER["REQUEST_METHOD"]==='POST'){
$json=file_get_contents('php://input');
    $obj=json_decode($json);
    $key=$obj->key;
    switch($key){
        case "submitdata":
            $name=filter_var($obj->uname,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $districtname=filter_var($obj->districtname,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $gtype=filter_var($obj->gtype,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $firstquestion=filter_var($obj->firstquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $secondquestion=filter_var($obj->secondquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $thirdquestion=filter_var($obj->thirdquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $fourthquestion=filter_var($obj->fourthquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $fifthquestion=filter_var($obj->fifthquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $sixthquestion=filter_var($obj->sixthquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $seventhquestion=filter_var($obj->seventhquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $eigthquestion=filter_var($obj->eigthquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $ninthquestion=filter_var($obj->ninthquestion,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $DB->query("INSERT INTO bitachallenge(participantname,participantgender,participantdistrict,particpant_date,participant_time,firstquestion,secondquestion,thirdquestion,fourthquestion,fifthquestion,sixthquestion,sevenquestion,eightquestion,ninthquestion) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            array($name,$gtype,$districtname,date("j/n/Y"),date("h:i a"),$firstquestion,$secondquestion,$thirdquestion,$fourthquestion,$fifthquestion,$sixthquestion,$seventhquestion,$eigthquestion,$ninthquestion));
            if ($DB->querycount == 1)
            {
            $data["message"] = "Data saved successfully";
            $data["status"] = "Ok";
            }
            else
            {
            $data["message"] = "data not saved successfully";
            $data["status"] = "error";    
            }
            $DB->closeConnection();
            break;
                case "login":
                    $username=filter_var($obj->uname,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
                    $password=filter_var($obj->pword,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
                    $getdata=$DB->row("SELECT name,uname,password  FROM `admin_management` where uname=? and password=?", 
                    array($username,$password));
                    if($DB->rowCount == 1){
                        $data["message"] = "Find related data";
                        $data["status"] = "Ok";
                        $data["name"]=$getdata['name'];
                        $data["username"]=$getdata['uname'];
                        }else{
                        $data["message"] = "No data find";
                        $data["status"] = "Ok";
                    }
                    $DB->closeConnection();
                    break;
                case "getalldata":
                    $getcatData=$DB->query("SELECT * FROM bitachallenge ORDER BY id DESC");
                    $data=$getcatData;
                    $DB->closeConnection();
                break;
                case "exportpostoftheday":
                    $id=filter_var($obj->fetchid,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
                    $getdata=$DB->query("SELECT participantname,participantgender,participantdistrict,particpant_date,participant_time,firstquestion,secondquestion,thirdquestion,fourthquestion,fifthquestion,sixthquestion,sevenquestion,eightquestion,ninthquestion 
                    FROM bitachallenge WHERE id=?",array($id));
                    $data=$getdata;
                    $DB->closeConnection();    
                    break; 
                    case "exportalldata":
                        $getdata=$DB->query("SELECT participantname,participantgender,participantdistrict,particpant_date,participant_time,firstquestion,secondquestion,thirdquestion,fourthquestion,fifthquestion,sixthquestion,sevenquestion,eightquestion,ninthquestion 
                        FROM bitachallenge");
                        $data=$getdata;
                        $DB->closeConnection();    
                        break; 
 }
}
else{
    $data["message"] = "Format not supported";
    $data["status"] = "error";    
}
   echo json_encode($data);