<?php
require_once("../../config.php");
	function getSingleMusicData($edit_id){
		$database = "if16_gittkaus_3";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("SELECT band, song, genre
		FROM user_music WHERE id=? 
			AND deleted IS NULL");
			
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($band, $song, $genre);
		$stmt->execute();
		
		$music = new Stdclass();
		
		if($stmt->fetch()){
			$music->band = $band;
			$music->song = $song;
			$music->genre = $genre;
			
		}else{
			header("Location: data.php");
			exit();
		}
		$stmt->close();
		$mysqli->close();
		return $music;
	}
	
	function updateMusic($id, $band, $song, $genre){
		
		$database = "if16_gittkaus_3";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);

		$stmt = $mysqli->prepare("UPDATE user_music SET band=?, song=?, genre=? WHERE id=? 
			AND deleted IS NULL");
		
		$stmt->bind_param("sssi",$band, $song, $genre, $id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "salvestus õnnestus!";
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteMusic($id){
		$database = "if16_gittkaus_3";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("UPDATE user_music SET deleted=NOW() WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$id);
		
		// kas õnnestus salvestada
		if($stmt->execute()){
			// õnnestus
			echo "kustutamine õnnestus!";
		}
		$stmt->close();
		$mysqli->close();
	}
?>