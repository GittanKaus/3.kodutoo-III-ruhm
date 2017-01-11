<?php
class User {
	
	private $connection;
	
	function __construct($mysqli) {
		$this->connection = $mysqli;	
	}
		
	function signup($email, $password) {
		
		$mysqli = new mysqli(
		
		$GLOBALS["serverHost"], 
		$GLOBALS["serverUsername"],  
		$GLOBALS["serverPassword"],  
		$GLOBALS["database"]
		
		);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password );
		if ( $stmt->execute() ) {
			echo "Sign up successful";	
		} else {	
			echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$this->connection->close();
		
	}
	
	function login($email, $password) {
		
		$error = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"],  $GLOBALS["serverPassword"],  $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		");
		
		echo $this->connection->error;
		
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		if ($stmt->fetch()) {
			
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo "User ".$id." logged in";
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION["message"] = "<h1>Welcome!</h1>";
				
				header("Location: data.php");
				
			} else {
				$error = "Wrong password!";
			}
			
		} else {
			$error = "This email doesn't excist";
		}
		
		return $error;
	}
}
?>