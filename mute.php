<?php 
		global $user;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
	if(isset($_GET['xuuid']) && isset($_GET['xname']) && isset($_GET['time'])) {
		$uuid = $_GET['xuuid'];
		$xname = $_GET['xname'];
		$time = $_GET['time'];
				$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
				$now = round(microtime(true) * 1000);
				if($time != "-1") {
				$atbanend = $now + (intval($time) *  24 * 60 * 60 * 1000);
				} else {
					$atbanend = -1;
				}
		$statement = $pdo->prepare("INSERT INTO MUTES (user,name,reason,till,byplayer,mutedat) VALUES (:uuid, :name, :reason, :till, :byplayer, :bannedat);");
		$result = $statement->execute(array('uuid' => $uuid, 'name' => $xname, 'reason' => 'ChatReport Mute', 'till' => $atbanend, 'byplayer' => $user, 'bannedat' => $now)); 
	
		$message = "<div class='card-panel green'><center><p class='white-text'>Der Mute wurde erfolgreich hinzugef&uumlgt. Weiterleitung in 2 Sekunden...</p></center></div>";
			header( "refresh:2;url=index.php?go=mutes" );
	}
		
	if(isset($_GET['uuid']) && isset($_GET['name'])) {
		
		$uuid = $_GET['uuid'];
		$name = $_GET['name'];
		
	}

?>
<?php if(isset($message)) echo $message;?>
<div class="card">
<div class="col s3">
</div>

<div class="col s4">
<div class="card">
<div class="card-content">
<center><span class="card-title">Muteparamenter festlegen</span></center>
<br \>
<div class="row">
<div class="col s2">
<center>
<a class="btn large blue-grey" href="?go=mute&xuuid=<?php echo $uuid;?>&xname=<?php echo $name;?>&time=1">1 Tag
</a>
</center>
</div>
<div class="col s2">
<center>
<a class="btn large blue-grey" href="?go=mute&xuuid=<?php echo $uuid;?>&xname=<?php echo $name;?>&time=3">3 Tage
</a>
</center>
</div>
<div class="col s2">
<center>
<a class="btn large blue-grey" href="?go=mute&xuuid=<?php echo $uuid;?>&xname=<?php echo $name;?>&time=7">7 Tage
</a>
</center>
</div>
<div class="col s2">
<center>
<a class="btn large blue-grey" href="?go=mute&xuuid=<?php echo $uuid;?>&xname=<?php echo $name;?>&time=14">14 Tage
</a>
</center>
</div>
<div class="col s2">
<center>
<a class="btn large blue-grey" href="?go=mute&xuuid=<?php echo $uuid;?>&xname=<?php echo $name;?>&time=21">21 Tage
</a>
</center>
</div>
<div class="col s2">
<center>
<a class="btn large blue-grey" href="?go=mute&xuuid=<?php echo $uuid;?>&xname=<?php echo $name;?>&time=-1">Permanent
</a>
</center>
</div>
</div>
 <br \>
</div>
</div>
</div>

</div>