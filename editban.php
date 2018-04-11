<?php 

	if(!isset($_GET['id'])) {
		header("Location: ?q=dashboard");
	}

	if(isset($_GET['update'])) {
		if($_POST['reason'] == "") {
			header("Location: ?go=dashboard");
		} else {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$id = $_GET['id'];
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("UPDATE BANS SET reason= :reason WHERE user= :email");
		$result = $statement->execute(array('email' => $id, 'reason' => $_POST['reason']));
		$info = "";
		}
	}
	
	function getInfo() {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$id = $_GET['id'];
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM BANS WHERE user = :email");
		$result = $statement->execute(array('email' => $id));
		$data = $statement->fetch();
		if($data == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Es wurde kein Spieler unter dieser ID gefunden.</i></div></div></center>";
		}
		else{
		$name = $data['name'];
		$reason = $data['reason'];
		$byuser = $data['byplayer'];
		$uid = $data['user'];
		$mil = $data['bannedat'];
		$seconds = $mil / 1000;
		$til = $data['till'];
		$totill = $til / 1000;
			echo '<div class="col s4 card grey darken-3 white-text">
			<div class="card-content white-text">
			<span class="card-title">' . $name . '</span>Grund: ' . $reason . ' <br \>Von: ' .$byuser . '<br \>Datum / Uhrzeit: ' . date("d/m/Y H:i:s \G\M\T", $seconds) . ' <br \> Ban bis: ' . date("d/m/Y H:i:s \G\M\T", $totill) . '
			<br \>
			</div></div> </div>
			<div class="col s8 card">
			<div class="card-content">
			<span class="card-title">
			Ver&aumlnderungen f&uumlr diesen Ban:
			</span>
			<form action="?go=editban&id=' . $_GET['id'] . '&update=true" method="post">
			 <div class="input-field col s6">
          Grund &aumlndern:
		  <input name="reason" id="reason" type="text" class="validate">
          <label for="reason"></label>
        </div>
						<div class="left">
						<br \>
		<button class="btn large grey darken-3" name="submit">&Aumlndern</button>
		</div>
		</form>
		<div class="right">
		<a href="?go=bans"><button class="btn large red">Zur&uumlck</button></a>
		</div>
		<br \>
			</div>
			</div>
			<br \> <br \>';
	}
	}

?>

<?php getInfo(); ?>