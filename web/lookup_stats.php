<?php
	if (isset($_POST["summonerName"]) && !empty($_POST["summonerName"])) {
		$db = pg_connect("host=ec2-54-247-95-125.eu-west-1.compute.amazonaws.com port=5432 dbname=d6ekuvikv3vj2u user=nsepsdirjogngr password=e9717b306d08ce71e6971bc0a987dc49163401e51ec9f70eb25c6d84c72c15a2");
		$summonerName = $_POST["summonerName"];
		$result = pg_query("SELECT * FROM wtol WHERE \"summonerName\" = '" . $summonerName . "'");
		
		$count = pg_num_rows($result);
		
		echo $count;
		
		$accountId = 0;
		$gameIndex = 0;
		$totalTime = 0;
		
		if ($count > 0) { // this summoner is already in the database
			$row = pg_fetch_row($result);
			$accountId = $row[0];
			$totalTime = (int) $row[1];
			$lastGameIndex = (int) $row[3];
			
			$gameIndex = $lastGameIndex + 1;
		} else { // we have to get all the games now :/
			// TODO: get the accountId
		}
		
		$fetchedGames = 0;
		
		do {
			$games = getGames($accountId, $gameIndex);
			
			if ($games) {
				echo "fetched games";
				
				$jsonGames = json_decode($games);
				$gamesArray = $jsonGames->games->games;
				$fetchedGames = count($gamesArray);
				
				echo $fetchedGames;
				
				for ($i = 0; $i < $fetchedGames; $i++) {
					echo "Duration: ";
					echo $gamesArray[i]->gameDuration;
					echo "\n";
					
					$totalTime += $gamesArray[i]->gameDuration;
				}
				
				$gameIndex += $fetchedGames;
			}
			
			$fetchedGames = 0;
		} while($fetchedGames >= 20);
		
		/*
		
		$lastGameIndex = $gameIndex - 1;
		
		if ($count > 0) { // update existing
			echo "updating";
		
			$query = "UPDATE wtol SET 'lastGameIndex'=" . $lastGameIndex . ", 'totalTime'=" . $totalTime . " WHERE 'accountId'=" . $accountId;
			$result = pg_query($query);
		} else { // insert new
			echo "inserting"
		
			$query = "INSERT INTO wtol VALUES (" . $accountId . ", " . $totalTime . ", '" . $summonerName . "', " . $lastGameIndex . ")";
			$result = pg_query($query);
		}
		
		*/
		
		// Speicher freigeben
		pg_free_result($result);
		
		// Verbindung schließen
		pg_close($db);
		
		echo $totalTime;
	}
	
	function getGames($accountId, $gameIndex) {
		if (is_numeric($gameIndex)) {
			$begGameIndex = (int) $gameIndex;
			$endGameIndex = $gameIndex + 20;
			
			$ch = curl_init(); 
			$url = "https://acs.leagueoflegends.com/v1/stats/player_history/EUW1/" . $accountId . "?begIndex=" . $begGameIndex . "&endIndex=" . $endGameIndex;			
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($httpcode == 200) {
				return $output;
			}
		}
		
		return FALSE;
	}
?>