<?php
	if (isset($_POST["summonerName"])) {
		$summonerName = $_POST["summonerName"];
		$ch = curl_init(); 
		// set url 
		curl_setopt($ch, CURLOPT_URL, "https://euw1.api.riotgames.com/lol/summoner/v3/summoners/by-name/" . $summonerName . "?api_key=RGAPI-8e2051b6-62f3-4f28-bca8-5e47d31b29e8"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		echo $output;
	} else if (isset($_POST["accountId"]) && isset($_POST["gameIndex"])) {
		http_response_code(404);
		
		$accountId = $_POST["accountId"];		
		$gameIndex = $_POST["gameIndex"];
		
		if (is_numeric($gameIndex)) {			
			$gameIndexInt = (int) $gameIndex;
			$gameEndIndex = $gameIndexInt + 20;
			
			echo $gameIndexInt . "\n";
			echo $gameEndIndex . "\n";
		
			$ch = curl_init(); 
			$url = "https://acs.leagueoflegends.com/v1/stats/player_history/EUW1/" . $accountId . "?begIndex=" . $gameIndexInt . "&endIndex=" . $gameEndIndex;			
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
			echo $output;
		} else {
			echo "gameIndex is no valid int";
		}
	}
?>