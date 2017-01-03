<?php
//edit.php
require("functions.php");
require("editFunctions.php");
//var_dump($_POST);

if(isset($_POST["update"])){
    updateMusic(cleanInput($_POST["id"]), cleanInput($_POST["band"]), cleanInput($_POST["song"]), cleanInput($_POST["genre"]));
    header("Location: edit.php?id=".$_POST["id"]."&success=true");
    exit();
}
if(!isset($_GET["id"])) {
    header("Location: music.php");
    exit();
}
$c = getSingleMusicData($_GET["id"]);
if(isset($_GET["success"])){
    echo "salvestamine õnnestus";
}
if(isset($_GET["delete"])){
    deleteMusic($_GET["id"]);
    header("Location: music.php");
    exit();
}
?>

<br>
<a href="music.php"> Back </a>

<h2>Change information</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="band" >Band</label><br>
	<input id="band" name="band" type="text" value="<?php echo $c->band;?>" ><br><br>
  	<label for="song" >Song</label><br>
	<input id="song" name="song" type="text" value="<?php echo $c->song;?>" ><br><br>
  	<label for="genre" >Genre</label><br>
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
		</select><br><br>
	<input type="submit" name="update" value="Salvesta">
  </form>
  
<br>
<a href="?id=<?=$_GET["id"];?>&delete=true">Delete</a>