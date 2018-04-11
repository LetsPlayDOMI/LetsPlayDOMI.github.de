<?php 

	if(!isset($_GET['id'])) {
		header("Location: ?go=dashboard");
	}
	
	function getInfo() {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$id = $_GET['id'];
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM Log WHERE chatlogid = :email");
		$result = $statement->execute(array('email' => $id));
		$msg = $statement->fetch();
		if($msg == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Es wurde kein Spieler unter dieser ID gefunden.</i></div></div></center>";
		}
		else{
		$statement = $pdo->prepare("SELECT * FROM LoggedMessages WHERE chatlogid = :email");
		$result = $statement->execute(array('email' => $id));
		$data3 = $statement->fetchAll();
		foreach($data3 as $dx) {
			$timing = $dx['timing'];
			$message = $dx['message'];
			$mil = intval($timing);
			$seconds = $mil / 1000;
			$translatedtime2 = date("H:i:s" , $seconds);
			$chat = $chat . "<div class='row'><div class='card'><div class='card-content'><span class='card-title'>" . $translatedtime2 . "</span><p class='float-text'>" . $message . "</p></div></div></div><br \>";
		}
			$name = $msg['username'];
			$iad = $msg['chatlogid'];
			echo '<div class="col s4 card grey darken-3 black-text">
			<div class="card-content black-text">
			<center><br \>
			<img height=100px width=100px src="https://minotar.net/avatar/' . $name . '"> <br \> <br \> <span class="card-title white-text">' . $name . '</span><p class="flow-text white-text">Server: ' . $msg['server'] . '</p><br \>' . $chat . '<br \>
			<br \>
			</center>
		<div class="right">
		<a href="?go=chatlogs"><button class="btn large red">Zur&uumlck</button></a>
		</div>
		<div class="left">
				<a href="?go=bans&playeruuid=' . $msg['uuid'] . '&playername=' . $msg['username'] . '"><button class="btn large green">Spieler bannen</button></a>
				<a href="?go=mutes&playeruuid=' . $msg['uuid'] . '&playername=' . $msg['username'] . '"><button class="btn large green">Spieler muten</button></a>
		</div>
		</div>
		<br \>
			<br \> <br \>';
	}
	}

?>

<?php getInfo(); ?>