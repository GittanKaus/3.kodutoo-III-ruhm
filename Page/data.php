<?php 
	// et saada ligi sessioonile
	require("../functions.php");
	
	//ei ole sisseloginud, suunan login lehele
	if(!isset ($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
		
	}
	
	
	//kas kasutaja tahab välja logida
	// kas aadressireal on logout olemas
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
		
	}
	
	$msg = " ";
	if(isset($_SESSION["message"])) {
		$msg = $_SESSION["message"];
	
	unset($_SESSION["message"]);
	
		}
	
	
?>


<?php require("../header.php"); ?>
<div class="container">
	<?=$msg;?>

	<h1></h1><p> Welcome <?=$_SESSION["userEmail"];?>!</p></h1>
	<p><a href="music.php"> Music </a></p>
	<a href="?logout=1"> Log out</a>


	<br><br>
	<br><br>
</div>
<?php require("../footer.php"); ?>