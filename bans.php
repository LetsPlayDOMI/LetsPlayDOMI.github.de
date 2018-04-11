<?php 
		global $user;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM LOGIN WHERE user= :user");
		$result = $statement->execute(array('user' => $user));
		$user3 = $statement->fetch();
		if (strpos($user3['permissions'], "BANS") == false) {
			header("Location: ?go=permissiondeny");
		}
		
	if(isset($_GET['editban'])) {
		header("Location: ?go=editban&id=" . $_GET['editban']);
	}
	if(isset($_GET['deleteban'])) {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("DELETE FROM BANS WHERE user= :user");
		$result = $statement->execute(array('user' => $_GET['deleteban']));
							$error = "<div class=\"card-panel light-green\">Aktualisierung erfolgreich</div>";
	}
	if(isset($_GET['playeruuid']) && isset($_GET['playername'])) {
		$uuid = $_GET['playeruuid'];
		$name = $_GET['playername'];
		header("Location: ?go=ban&uuid=" . $uuid . "&name=" . $name);
	}
	
		function echoBans() {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM BANS ORDER BY bannedat DESC");
		$result = $statement->execute();
		$user2 = $statement->fetchAll();
		if(isset($error)) {
			echo $error;
		}
		if($user2 == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Keine gebannten Spieler</i></div></div></center>";
		}
		foreach($user2 as $s) {
		$name = $s['name'];
		$reason = $s['reason'];
		$byuser = $s['byplayer'];
		$uid = $s['user'];
			echo '<div class="card grey darken-3 white-text">
			<div class="card-content white-text">
			<span class="card-title">' . $name . '</span>Grund: ' . $reason . ' <br \>Von: ' .$byuser . '<br \>
			<br \>
			<div class="right">
				<a href="?go=bans&editban=' . $uid . '"class="btn-floating btn-large light-green"><i class="material-icons">mode_edit</i></a>
				<a href="?go=bans&deleteban=' . $uid . '"class="btn-floating btn-large red"><i class="material-icons">remove</i></a>
				</div>
			</div></div> <br \> <br \>';
		}
	}


?>

<div class="card">
<div class="col s3">
</div>

<div class="col s4">
<div class="card">
<div class="card-content">
<center><span class="card-title">Alle Bans (&Uumlbersicht)</span></center>
<?php echoBans(); ?>
</div>
</div>
</div>

</div>