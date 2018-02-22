<?php
	if (isset($_POST["summonerName"]) && !empty($_POST["summonerName"])) {
		$db = pg_connect("host=ec2-54-247-95-125.eu-west-1.compute.amazonaws.com port=5432 dbname=d6ekuvikv3vj2u user=nsepsdirjogngr password=e9717b306d08ce71e6971bc0a987dc49163401e51ec9f70eb25c6d84c72c15a2");
		$summonerName = $_POST["summonerName"];
		$result = pg_query("SELECT * FROM wtol WHERE \"summonerName\" = '" . $summonerName . "'");
		
		$count = pg_num_rows($result);
		
		if ($count > 0) { // this summoner is already in the database
			$row = pg_fetch_row($result);
			$accountId = $row[0];
			$gameCount = $row[1];
			$summonerName = $row[2];
			$totalTime = $row[3];
			
			echo $accountId;
			echo $gameCount;
			echo $summonerName;
			echo $totalTime;
		} else { // we have to get all the games now :/
			
		}
		
		// Speicher freigeben
		pg_free_result($result);
		
		// Verbindung schließen
		pg_close($db);
	}
?>