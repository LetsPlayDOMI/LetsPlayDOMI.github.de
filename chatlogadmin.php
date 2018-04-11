<?php 
		global $user;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM LOGIN WHERE user= :user");
		$result = $statement->execute(array('user' => $user));
		$user3 = $statement->fetch();
		if (strpos($user3['permissions'], "CHATLOG") == false) {
			header("Location: ?go=permissiondeny");
		}
		
	if(isset($_GET['editlog'])) {
		header("Location: ?go=editlog&id=" . $_GET['editlog']);
	}

if(isset($_GET['deletelog'])) {
			global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
	$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase , $dataUser, $dataPass);
	$statement = $pdo->prepare("DELETE FROM LoggedMessages WHERE chatlogid = :rid");
	$result = $statement->execute(array('rid' => $_GET['deletelog']));
	$statement = $pdo->prepare("DELETE FROM Log WHERE chatlogid = :rid");
	$result = $statement->execute(array('rid' => $_GET['deletelog']));

	header("#");
}
	
		function echoBans() {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM Log");
		$result = $statement->execute();
		$user2 = $statement->fetchAll();
		if(isset($error)) {
			echo $error;
		}
		if($user2 == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Keine ChatLogs vorhanden...</i></div></div></center>";
		}
		foreach($user2 as $s) {
			$name = $s['username'];
			$iad = $s['chatlogid'];
			echo '<div class="card grey darken-3 white-text">
			<div class="card-content white-text">
			<span class="card-title">' . $name . '</span>ChatLog-ID: ' . $iad . '<br \>
			<br \>
			<div class="right">
				<a href="?go=chatlogs&editlog=' . $iad . '"class="btn-floating btn-large light-green"><i class="material-icons">mode_edit</i></a>
				<a href="?go=chatlogs&deletelog=' . $iad . '"class="btn-floating btn-large red"><i class="material-icons">remove</i></a>
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
<center><span class="card-title">Alle Chatlogs (&Uumlbersicht)</span></center>
<?php echoBans(); ?>
</div>
</div>
</div>

</div>