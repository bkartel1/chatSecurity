<?php

	include_once('include/config.php');	
	include_once('include/AES.php');
	
	if(isset($_POST['root']) && isset($_POST['id']) && $_POST['root']=="caputotavellamantovani99" && isset($_POST["password"])){
		$connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD,DB_NAME) or die( "Unable to connect");
		if(!mysqli_connect_errno()){
			
			$id=$_POST["id"];
			$id=mysqli_real_escape_string($connection,$id);
			$password=$_POST["password"];
			$password=mysqli_real_escape_string($connection,$password);
			$result1=mysqli_query($connection,"SELECT * FROM User WHERE id_user='{$id}'");
			if($result1){
				$result1=mysqli_fetch_assoc($result1);
				$result2=mysqli_query($connection,"SELECT * FROM Chiavi WHERE id_key ='{$result1['id_key']}' AND password='{$password}'");
				if($result2){
		
					$id=mysqli_real_escape_string($connection,$_POST['id']);
					$result=mysqli_query($connection,"SELECT * FROM Have WHERE id_user='{$id}'");
					$response=array();
					if($result){
						$response["conversazioni"]=array();
						while($have=mysqli_fetch_assoc($result)){
					
						$conversation=mysqli_query($connection,"SELECT * FROM Conversation WHERE id_conversation='{$have['id_conversation']}'");
						if($conversation){
							$tmp = array();
							$conversation=mysqli_fetch_assoc($conversation);
							$tmp["id_conversation"]=$conversation["id_conversation"];
							$tmp["user_1"]=$conversation["user_1"];
							$tmp["user_2"]=$conversation["user_2"];
							array_push($response["conversazioni"], $tmp);
							}
						}
						$response["errore"]=false;
					}else{
						$response["errore"]=true;
						$response["risultato"]="errore nella query have";
					}
				}else{
					$response["errore"]=true;
					$response["risultato"]="errore nella utente non esistente,p";
				}
			}else{
				$response["errore"]=true;
				$response["risultato"]="errore nella utente non esistente";
			}
		}else{
			$response["errore"]=true;
			$response["risultato"]="errore nella connessione";
		}
		echo json_encode($response);
	}else{
		
	}

?>