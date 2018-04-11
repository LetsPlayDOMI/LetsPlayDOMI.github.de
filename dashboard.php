<?php 

	global $dataHost;
	global $dataUser;
	global $dataPass;
	global $dataDatabase;
	
		function readBans() {
				global $dataHost;
	global $dataUser;
	global $dataPass;
	global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM BANS ORDER BY bannedat DESC LIMIT 5");
		$result = $statement->execute();
		$user2 = $statement->fetchAll();
		if($user2 == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Keine gebannten Spieler</i></div></div></center>";
		}
		foreach($user2 as $s) {
		$name = $s['name'];
		$reason = $s['reason'];
		$byuser = $s['byplayer'];
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><span class='card-title'>$name</span>Grund: $reason <br \>Von: $byuser</div></div></center>";
		}
	}
	
	$servermotd = "aktualisiere...";
	$servermotdsecond = "aktualisiere...";
	
	function readUsages() {
			global $dataHost;
	global $dataUser;
	global $dataPass;
	global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM ACP WHERE vsdnc=1");
		$result = $statement->execute();
		$user2 = $statement->fetch();
		
		$ramusage = formatBytes($user2['ramusage']);
		$cpuusage = $user2['cpuusage'];
		$rammass = formatBytes($user2['rammass']);
		
		$servermotd = $user2['motdfirst'];
		$servermotdsecond = $user2['motdsecond'];
		echo "<br \>";
		echo '<div class="progress white">
			<div class="determinate red" style="width: ' . ($user2['rammass'] / $user2['ramusage']) * 28 . '%"></div>
		</div>';
		echo "<br \>";
		echo $ramusage . " von " . $rammass. " verbraucht <br \>";
		echo $cpuusage . " CPU Kerne verf&uumlgbar!";
	}
	
	function readMutes() {
			global $dataHost;
	global $dataUser;
	global $dataPass;
	global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM MUTES ORDER BY mutedat DESC LIMIT 5");
		$result = $statement->execute();
		$user2 = $statement->fetchAll();
		
		if($user2 == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Keine gemuteten Spieler</i></div></div></center>";
		}
		foreach($user2 as $s) {
		$name = $s['name'];
		$reason = $s['reason'];
				$byuser = $s['byplayer'];
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><span class='card-title'>$name</span>Grund: $reason <br \>Von: $byuser</div></div></center>";
		}
	}
	
	function formatBytes($size, $precision = 2)
	{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' ' . $suffixes[floor($base)];
	}

?>

<div class="row">
<div class="col s3">
<div class="card">
<div class="card-content">
<span class="card-title">... 5 zuletzt gebannte Spieler</span>
<br \>
	<?php readBans(); ?>
	<center>
			<br \>
		<a href="?go=bans"><button class="btn large grey darken-3 white-text">Alle Bans ansehen</button></a>
	</center>
</div>
</div>
</div>
<center>
<div class="col s6 center">
	<div class="card transparent">
		<div class="card-content">
		<span class="card-title white-text center"><center>Guten Tag <?php echo $user; ?> :)</span></center>
		<br \>
		<center>Derzeitige Auslastung des BungeeCords:
		<center><?php readUsages(); ?>
		</center>
		</div>
	</div>
</div>
</center>
<div class="col s3">
<div class="card">
<div class="card-content">
<span class="card-title">... 5 zuletzt gemutete Spieler</span>
<br \>
	<?php readMutes(); ?>
	<center>
			<br \>
		<a href="?go=mutes"><button class="btn large grey darken-3 white-text">Alle Mutes ansehen</button></a>
	</center>
</div>
</div>
</div>
</div>