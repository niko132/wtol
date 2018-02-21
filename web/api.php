<?php
	if (isset($_POST["summonerName"])) {
		$summonerName = $_POST["summonerName"];
		$ch = curl_init(); 
		$url = "https://euw1.api.riotgames.com/lol/summoner/v3/summoners/by-name/" . $summonerName . "?api_key=RGAPI-8e2051b6-62f3-4f28-bca8-5e47d31b29e8";
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		echo $output;
	} else if (isset($_POST["accountId"]) && isset($_POST["gameIndex"])) {		
		$accountId = $_POST["accountId"];		
		$gameIndex = $_POST["gameIndex"];
		
		if (is_numeric($gameIndex)) {			
			$gameIndexInt = (int) $gameIndex;
			$gameEndIndex = $gameIndexInt + 20;
			
			$ch = curl_init(); 
			$url = "https://acs.leagueoflegends.com/v1/stats/player_history/EUW1/" . $accountId . "?begIndex=" . $gameIndexInt . "&endIndex=" . $gameEndIndex;			
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($httpcode == 200) {
				echo $output;
			} else {
				http_response_code($httpcode);
			}
		} else {
			echo "gameIndex is no valid int";
		}
	} else if (isset$_POST["test"]) {
		$db = pg_connect("host=ec2-54-247-95-125.eu-west-1.compute.amazonaws.com port=5432 dbname=d6ekuvikv3vj2u user=nsepsdirjogngr password=e9717b306d08ce71e6971bc0a987dc49163401e51ec9f70eb25c6d84c72c15a2");
		$result = pg_query("INSERT INTO test (test1) VALUES (400)");
	}
?>