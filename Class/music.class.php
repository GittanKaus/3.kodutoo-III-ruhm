<?php

class Music{
	
		private $connection;
        function __construct($mysqli){
            $this->connection = $mysqli;
		}
		
		function delete($id){
            $stmt = $this->connection->prepare("UPDATE user_music SET deleted=NOW() WHERE id=? AND deleted IS NULL");
			$stmt->bind_param("i", $id);

            if ($stmt->execute()) {

                echo "Deleted";
            }
            $stmt->close();
        }
		
		function get($q, $sort, $direction){

            $allowedSortOptions = ["id", "email", "band", "song", "genre"];

            if (!in_array($sort, $allowedSortOptions)){
					$sort = "id";
            }
            echo "Sorting: " .$sort. " ";

            $orderBy = "ASC";
            if ($direction == "descending"){
                $orderBy = "DESC";
            }
			
            echo "Order: " .$orderBy. " ";
           
		   if ($q == ""){
				
                echo "Not searching";
				
                $stmt = $this->connection->prepare("
                    SELECT id, email, band, song, genre
                    FROM user_music
                    WHERE deleted IS NULL 
                    ORDER BY $sort $orderBy 
				");
				
            } else {
				
                echo "Searches: " . $q;
				

                $searchword = "%".$q."%";
                $stmt = $this->connection->prepare("
                    SELECT id, email, band, song, genre
                    FROM user_music
                    WHERE deleted IS NULL AND
                    (id LIKE ? OR email LIKE ?)
                    ORDER BY $sort $orderBy 
				");
                $stmt->bind_param("ss", $searchword, $searchword);
				
            }
			
            echo $this->connection->error;
			
            $stmt->bind_result($id, $email, $band, $song, $genre);
            $stmt->execute();
			
            $result = array();

            while ($stmt->fetch()) {

                $music = new StdClass();
                $music->id = $id;
                $music->email = $email;
                $music->band = $band;
                $music->song = $song;
                $music->genre = $genre;

                array_push($result, $music);
            }
            $stmt->close();
            return $result;
        }
		
		function cleanInput ($input) {
		
			$input = trim($input);
		
			$input = stripslashes($input);
		
			$input = htmlspecialchars($input);
		
			return $input;
		
	}
	
		function getSingle($edit_id){
			$stmt = $this->connection->prepare("SELECT band, song, genre FROM user_music WHERE id=? 
				AND deleted IS NULL");

			echo $this->connection->error;
			$stmt->bind_param("i", $edit_id);
			$stmt->bind_result($band, $song, $genre);
			$stmt->execute();

			$music = new Stdclass();
			if ($stmt->fetch()) {
				$music->band = $band;
				$music->song = $song;
				$music->genre = $genre;
			} else {
				header("Location: music.php");
				exit();
			}
			$stmt->close();
			return $music;
		}
		
		function save($email, $band, $song, $genre){
            $stmt = $this->connection->prepare("INSERT INTO user_music(email, band, song, genre) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $email, $band, $song, $genre);
            if ($stmt->execute()) {
                echo "salvestamine �nnestus";
            } else {
                echo "ERROR " . $stmt->error;
            }
            $stmt->close();
            $this->connection->close();
        }

		function update($id, $band, $song, $genre){
            $stmt = $this->connection->prepare("UPDATE user_music SET band=?, song=?, genre=? WHERE id=? 
                    AND deleted IS NULL");
            $stmt->bind_param("sssi", $band, $song, $genre, $id);

            if ($stmt->execute()) {

                echo "salvestus õnnestus!";
            }
            $stmt->close();
        }
}
?>