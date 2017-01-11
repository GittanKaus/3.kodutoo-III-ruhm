<?php 
	
	require("../functions.php");
	require("../Class/music.class.php");
	$music = new music($mysqli);
	
	$email = "";
	$band = "";
	$song = "";
	$genre = "";
	

	if (!isset($_SESSION["userId"])){
		

		header("Location: login.php");
		exit();
	}
	

	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
		
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		unset($_SESSION["message"]);
	}
	
	if (isset($_POST["band"]) &&
    !empty ($_POST["band"])) {
        $band = $Helper->cleanInput($_POST["band"]);
	}
	
	if (isset($_POST["song"]) &&
    !empty ($_POST["song"])) {
        $song = $Helper->cleanInput($_POST["song"]);
    }
	
	if (isset($_POST["genre"]) &&
    !empty ($_POST["genre"])) {
        $genre = $Helper->cleanInput($_POST["genre"]);
    }
	
$error= "";	
	
	if(isset($_POST["band"]) &&
		isset($_POST["song"]) &&
		isset($_POST["genre"]) &&
		!empty($_POST["band"]) &&
		!empty($_POST["song"]) &&
		!empty($_POST["genre"])) {
			
		$music->save($Helper->cleanInput($_SESSION["userId"]), $Helper->cleanInput($_POST["band"]),
			$Helper->cleanInput($_POST["song"]), $Helper->cleanInput($_POST["genre"]));
		
		} 
	elseif(isset($_POST["band"]) &&
			isset($_POST["song"]) &&
			isset($_POST["genre"]) &&
			empty($_POST["band"]) &&
			empty($_POST["song"]) &&
			empty($_POST["genre"])) {
			$error = "Fill all";
		}
	echo $error;
	
		//sorteerib
	if(isset($_GET["sort"]) && isset($_GET["direction"])){
		$sort = $_GET["sort"];
		$direction = $_GET["direction"];
	} else {
		//kui ei ole määratud siis vaikimis id ja ASC
		$sort = "id";
		$direction = "ascending";
		
	}
	
	//kas otsib
	if(isset($_GET["q"])){
		
		$q = $Helper->cleanInput($_GET["q"]);
		
		$musicData = $music->get($q, $sort, $direction);
	
	} else {
		$q = "";
		$musicData = $music->get($q, $sort, $direction);
	
	}
	
?>	

<?php require("../header.php"); ?>

<div class="container">

		<p><a href="data.php"> <button onclick="goBack()">Go Back</button></a></p> 
		<h1>Music</h1>
		<?=$msg;?>
			<p>
			Welcome <?=$_SESSION["userEmail"];?>!
			<a href="?logout=1">Log out</a>
			</p>

		<h2> Add data </h2>
		
			<form method="POST">
				
				<label>Band:</label><br>
				<input name="band" type="text" value="<?=$band;?>">
				
				<br><br>
				
				<label>Song:</label><br>
				<input name="song" type="text" value="<?=$song;?>">
				
				<br><br>

				
				<label>Song genre:</label><br>
					<select name="genre">
						<option value="Alternative" <?php echo $result['genre'] == 'Alternative' ? 'selected' : ''?> >Alternative</option>
						<option value="Anime" <?php echo $result['genre'] == 'Anime' ? 'selected' : ''?>>Anime</option>
						<option value="Blues" <?php echo $result['genre'] == 'Blues' ? 'selected' : ''?>>Blues</option>
						<option value="Children’s Music" <?php echo $result['genre'] == 'Children’s Music' ? 'selected' : ''?> >Children’s Music</option>
						<option value="Classical" <?php echo $result['genre'] == 'Classical' ? 'selected' : ''?>>Classical</option>
						<option value="Comedy" <?php echo $result['genre'] == 'Comedy' ? 'selected' : ''?>>Comedy</option>
						<option value="Country" <?php echo $result['genre'] == 'Country' ? 'selected' : ''?>>Country</option>
						<option value="Dance/EMD" <?php echo $result['genre'] == 'Dance / EMD' ? 'selected' : ''?> >Dance / EMD</option>
						<option value="Electronic" <?php echo $result['genre'] == 'Electronic' ? 'selected' : ''?>>Electronic</option>
						<option value="Hip-Hop/Rap" <?php echo $result['genre'] == 'Hip-Hop/Rap' ? 'selected' : ''?>>Hip-Hop/Rap</option>
						<option value="Jazz" <?php echo $result['genre'] == 'Jazz' ? 'selected' : ''?>>Jazz</option>
						<option value="New Age" <?php echo $result['genre'] == 'New Age' ? 'selected' : ''?>>New Age</option>
						<option value="Pop" <?php echo $result['genre'] == 'Pop' ? 'selected' : ''?>>Pop</option>
						<option value="Reggae" <?php echo $result['genre'] == 'Reggae' ? 'selected' : ''?>>Reggae</option>
						<option value="Rock" <?php echo $result['genre'] == 'Rock' ? 'selected' : ''?>>Rock</option>
						</select>
					
				<input type="submit" value="Submit">
				
			
		</form>
		
		<h2>Music</h2>
		
		<form>
			<input type="search" name="q">
			<input type="submit" value="Search">
		</form>
		
	<?php
		
		$direction = "ascending";
		if(isset($_GET["direction"])){
			if ($_GET["direction"] == "ascending"){
				$direction = "descending";
			}
		}
		$html = "<table class='table table-striped table-bordered'>";
		$html .= "<tr>";
			$html .= "<th><a href=?q=".$q."&sort=id&direction=".$direction."'>id</a></th>";
			$html .= "<th><a href=''?q=".$q."&sort=email&direction=".$direction."'>email</a></th>";
			$html .= "<th><a href=''?q=".$q."&sort=band&direction=".$direction."'>band</a></th>";
			$html .= "<th><a href=''?q=".$q."&sort=song&direction=".$direction."'>song</a></th>";
			$html .= "<th><a href=''?q=".$q."&sort=genre&direction=".$direction."'>genre</a></th>";
		$html .= "</tr>";
		
		foreach($musicData as $i){
			
				$html .= "<td>".$i->id."</td>";
				$html .= "<td>".$i->email."</td>";
				$html .= "<td>".$i->band."</td>";
				$html .= "<td>".$i->song."</td>";
				$html .= "<td>".$i->genre."</td>";
				$html .= "<td><a href='edit.php?id=".$i->id."'>
				<span class=\"glyphicon glyphicon-cog\"></span></a></td>";
				
				$html .= "</tr>";
			}
			
			$html .= "</table>";
			
			echo $html;
	?>

</div>

<?php require("../footer.php"); ?>