<?php
	if (isset($_POST["summonerName"]) && !empty($_POST["summonerName"])) {
		$db = pg_connect("host=ec2-54-247-95-125.eu-west-1.compute.amazonaws.com port=5432 dbname=d6ekuvikv3vj2u user=nsepsdirjogngr password=e9717b306d08ce71e6971bc0a987dc49163401e51ec9f70eb25c6d84c72c15a2");
		$summonerName = $_POST["summonerName"];
		$result = pg_query("SELECT * FROM wtol WHERE \"summonerName\" = '" . $summonerName . "'");
		
		$count = pg_num_rows($result);
		
		echo $count;
		echo "<br>";
		echo "nice";
	}
?>