<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Razorpay\Api\Api;

$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
if($curPageName == 'buy_plan.php'){ 
    require_once ('assets/library/razorpay-php/razorpay-php/Razorpay.php');
}
function SendMail($email, $content)
{
    //Load Composer's autoloader
    require 'vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail = new PHPMailer();
        //$mail->SMTPDebug = true;
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port = 465;
        $mail->Host = "ssl://sg1-ts7.a2hosting.com";
        $mail->Username = "admin@recovery.starkinsolutions.com";
        $mail->Password = ";QWMRbwj!QI[";

        $mail->setFrom('admin@recovery.starkinsolutions.com', 'Team Jrreddy');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Jrreddy!';
        $mail->Body = $content;

        $result = $mail->send();		
		return $result;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function escapeString($str){
	global $mysql_connection;
	$str = mysqli_real_escape_string($mysql_connection , $str);
	return $str;
}
function getAffectedRowCount($sql){
    global $mysql_connection;
    $query = mysqli_query($mysql_connection, $sql);
    return mysqli_num_rows($query);
}
function executeQuery($sql){
    global $mysql_connection;
    return mysqli_query($mysql_connection, $sql);
}
function executeInsert($table, $data, $onduplicatekey = array()){
	global $mysql_connection;
    $dataStr = '';
    if (strlen($table) > 0){
        $dataStr = 'INSERT INTO '.$table;
        if (count($data) > 0){
            $datarow = '';
            foreach ($data as $key => $value){
                $datarow.="{$key} = '{$value}',";
            }
            $datarownew = substr($datarow, 0, -1);
            $dataStr = $dataStr.' SET '.$datarownew;
        }
        if (count($onduplicatekey) > 0){
            foreach ($onduplicatekey as $dkey => $dvalue){
                $duplicaterow.="{$dkey} = '{$dvalue}',";
            }
            $duplicaterownew = substr($duplicaterow, 0, -1);
            $dataStr = $dataStr.' ON DUPLICATE KEY UPDATE '.$duplicaterownew;
        }
    }
    mysqli_query($mysql_connection, $dataStr);
    $result = mysqli_insert_id($mysql_connection);
    return $result;
}
function executeUpdate($table, $data, $clause){
	global $mysql_connection;
    $dataStr = '';
    if (strlen($table) > 0){
        if (count($data) > 0){
            $datarow = '';
            foreach ($data as $key => $value){
                $datarow.="{$key} = '{$value}',";
            }
            $datarownew = substr($datarow, 0, -1);
            $dataStr = $dataStr.$datarownew;
        }
    }
    $row_clause = '';
    $clause_array = array();
    if (strlen($table) > 0){
        if(count($clause) > 0){
            foreach ($clause as $key => $value){
                $row_clause ="{$key} = '{$value}'";
                array_push($clause_array, $row_clause);
            }
            $clausenew = implode(" AND " ,$clause_array);
        }
    }
    $result = mysqli_query($mysql_connection, "UPDATE {$table} SET {$dataStr} WHERE {$clausenew}");
    return $result;
}
function executeSelect($table, $data = array(), $clause = array(), $orderby = "", $limit = array()) {
	global $mysql_connection;
    $dataStr = 'SELECT';
    $datanew = '';
    if (strlen($table) > 0){
        if (count($data) > 0){
            foreach ($data as $key => $value){
                $datanew.=" {$value},";
            }
            $datan = substr($datanew, 0, -1);
            $dataStr = $dataStr.$datan;
        }else{
            $dataStr = $dataStr.' * ' ;
        }
        $dataStr = $dataStr.' FROM '.$table ;
        $row_clause = '';
        $clause_array = array();
        if(count($clause) > 0){
            foreach ($clause as $key => $value){
                $row_clause ="{$key}='{$value}'";
                array_push($clause_array, $row_clause);
            }
            $clausenew = implode(" AND " ,$clause_array);
            
            $dataStr = $dataStr.' WHERE '.$clausenew;
        }
        if(strlen($orderby) > 0){
            $dataStr = $dataStr.' ORDER BY '.$orderby;
        }
        if(count($limit) > 0){
            foreach($limit as $key => $value){
                $datalimit.=" {$value},";
            }
            $datalimit = substr($datalimit, 0, -1);
            
            $dataStr = $dataStr.' LIMIT '.$datalimit;
        }
    }
    $report = mysqli_query($mysql_connection, $dataStr);
    $result = array();
    while($queryreturn = mysqli_fetch_assoc($report)){
        $result[] = $queryreturn;
    }
    return $result;
}
function executeSelectSingle($table_name, $fields = array(), $conditions = array(), $orderby = ""){
	global $mysql_connection;
    $data = array();
    if(strlen($table_name) > 0){
        $sql = "";
        if(count($fields) > 0){
            $sql .= "SELECT " . implode(",", $fields) . " FROM " . $table_name;
        }else{
            $sql .= "SELECT * FROM " . $table_name;
        }
        $where = array();
        foreach($conditions as $key => $value){
            $where[] = $key . "='" .$value."'";
        }
        if(count($where) > 0){
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        if(strlen($orderby) > 0){
            $sql = $sql.' ORDER BY '.$orderby;
        }
        $sql .= " LIMIT 1";

        $query = mysqli_query($mysql_connection, $sql);
        if(mysqli_num_rows($query) > 0){
            $data = mysqli_fetch_assoc($query);
        }
    }
    return $data;
}
function executeDelete($table, $clause){
    global $mysql_connection;
    $row_clause = '';
    $clause_array = array();
    if (strlen($table) > 0){
        if(count($clause) > 0){
            foreach ($clause as $key => $value){
                $row_clause ="{$key} = '{$value}'";
                array_push($clause_array, $row_clause);
            }
            $clausenew = implode(" AND " ,$clause_array);
        }
    }
   $result = mysqli_query($mysql_connection, "DELETE FROM {$table} WHERE {$clausenew}");

   return $result;
}
function executeTruncate($table){
    global $mysql_connection;
    if (strlen($table) > 0){
        $result = mysqli_query($mysql_connection, "TRUNCATE TABLE ".$table);
        return $result;
    }else{
        return false;
    }
}
function getResultAsArray($sql){
	global $mysql_connection;
    $row = array();
    $query = mysqli_query($mysql_connection, $sql);
    if(mysqli_num_rows($query) > 0){
        while($result = mysqli_fetch_assoc($query)){
            $row[] = $result;
        }
    }
    return $row;
}
function executeQueryToArray($res){
    $result = array();
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $result[] = $row;
        }
    }
    return $result;
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}