<?php
	$ch = curl_init(); 
	// set url 
	curl_setopt($ch, CURLOPT_URL, "https://euw1.api.riotgames.com/lol/summoner/v3/summoners/by-name/" . $_POST["test"] . "?api_key=RGAPI-8e2051b6-62f3-4f28-bca8-5e47d31b29e8"); 
	//return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	// $output contains the output string 
	$output = curl_exec($ch); 
	// close curl resource to free up system resources
	curl_close($ch);
	
	echo $output;
?>