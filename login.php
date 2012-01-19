<?php

session_start();

# We require the library  
require("facebook.php");  
  
$facebook = new Facebook(array(  
    'appId'  => '177971028917849',  
    'secret' => '3247b0c6ff1969ba5945b0b628f3b4d6',  
    'cookie' => true  
)); 
  
$session = $facebook->getSession(); 
 
# Active session, let's try getting the user id (getUser()) and user info (api->('/me'))  
try {  
 	$uid = $facebook->getUser();  
  	$user = $facebook->api('/me');  
} catch (Exception $e){}  
  
if(!empty($user)){  
    #USER
    echo json_encode($user);
	
	$student = json_decode(json_encode($user));
	
	#DB
	$hostname = 'ceids.db.7194931.hostedresource.com';
	$username = 'ceids';
	$password = 'M@urici0';
	$dbname = 'ceids';
	
	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	$search = mysql_query("SELECT * from students where fid = '" . $student->id . "'");
	
	if(mysql_num_rows($search) == 0){
		$query = mysql_query("INSERT INTO students (name,firstname,lastname,fid) VALUES(" .
		"'" . $student->name . "'," .
		"'" . $student->first_name . "'," .
		"'" . $student->last_name . "'," .
		"'" . $student->id . "');");
		
		if(!$query){
			echo mysql_error();
		}
	}
	
	#SESSION
	
	$getStudent = mysql_query("SELECT id from students where fid = '" . $student->id . "';");
	$row = mysql_fetch_assoc($getStudent);
	$_SESSION["id"] = $row["id"];
	$_SESSION["fid"] = $student->id;
	$_SESSION["name"] = $student->name;
	$_SESSION["first_name"] = $student->first_name;
	$_SESSION["last_name"] = $student->last_name;
	
} else { 
    # Error 
    die("Hubo un error.");  
}  
?>