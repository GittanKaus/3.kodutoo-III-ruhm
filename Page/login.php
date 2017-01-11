<?php 
	
	require("/home/gittkaus/config.php");
	require("../functions.php");
	
	require("../Class/user.class.php");
		$User = new User($mysqli);
	
	if(isset ($_SESSION["userId"])) {
		header("Location: data.php");
		exit();
	}
		
	$signupEmailError = "";
	$signupEmail = "";
	$signupPasswordError = "";
	$signupPassword = "";
	$gender = "";
	$genderError = "";
	$loginEmailError = "";
	$loginEmail = "";
	$loginPasswordError = "";
	$loginPassword = "";
	

	if(isset($_POST["signupEmail"])){
		if(empty($_POST["signupEmail"])){
			$signupEmailError = "This is field obligatory";
		} else {	
			$signupEmail = $_POST["signupEmail"];
		}
		
	}
	
	if (isset ($_POST["signupPassword"])) {
		if (empty ($_POST["signupPassword"])) {	
			$signupPasswordError = "This is field obligatory";
		} else {	
			$signupPassword = $_POST["signupPassword"];
		}
		
	}
	
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){
			$genderError = "This is field obligatory";
		} else {
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupEmail"]) && 
			 isset($_POST["signupPassword"]) &&
			 isset($_POST["gender"]) &&
			 $signupEmailError == "" && 
			 empty($signupPasswordError)) {
		
		echo "Saving... <br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		$User->signUp($Helper->cleanInput($_POST['signupEmail']),
		$Helper->cleanInput ($password));
		
	}
	
	$error ="";
	if ( isset($_POST["loginEmail"]) && 
		isset($_POST["loginPassword"]) && 
		!empty($_POST["loginEmail"]) && 
		!empty($_POST["loginPassword"])
	  ) {
		  
		$error = $User->login($Helper->cleanInput($_POST["loginEmail"]), 
		$Helper->cleanInput($_POST["loginPassword"]));
		
	}
	
	
?>

<?php require("../header.php"); ?>

<div class="container">

    <div class="row">

        <div class="col-sm-3">

		<h1>Logi in</h1>
		<p style="color:red;"><?php echo $error; ?></p>
		<form method="POST">
			
			<label>Email</label><br>
			<input name="loginEmail" type="email"> <?php echo $loginEmailError; ?>
			
			<br><br>
			
			<label>Password</label><br>
			<input name="loginPassword" type="password"> <?php echo $loginPasswordError; ?>
						
			<br><br>
			
			<input type="submit">
		
		</form>
		
	</div>	
		
	<div class="col-sm-3 col-sm-offset-3">
		
		<h1>Create user</h1>
		
		<form method="POST">
			
			<label>Email</label><br>
			<input name="signupEmail" type="email"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<label>Password</label><br>
			<input placeholder="Parool" name="signupPassword" type="password"> <?php echo $signupPasswordError; ?>
						
			<br><br> 
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked > Mees<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male"> Mees<br>
			<?php } ?>
			
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked > Naine<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> Naine<br>
			<?php } ?>
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked > Muu<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other"> Muu<br>
			<?php } ?>
			
			<input type="submit" value="Save">
		
		</form>

	</body>
</html>