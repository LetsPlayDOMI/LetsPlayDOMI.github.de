<?php
		global $user;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM LOGIN WHERE user= :user");
		$result = $statement->execute(array('user' => $user));
		$user2 = $statement->fetch();
		if (strpos($user2['permissions'], "WERBUNG") == false) {
			header("Location: ?go=permissiondeny");
		}
	if(isset($_GET['do']) && $_GET['do'] == "add") {
				global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM ACP WHERE vsdnc = 1");
		$result = $statement->execute();
		$user2 = $statement->fetch();
		if(isset($error)) {
			echo $error;
		}
		if($user2 == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Keine W&oumlrter eingetragen!</i></div></div></center>";
		}
		$words = $user2['blockads'];
		
		$newable = $_POST['word'] . "," . $words;
		$statement = $pdo->prepare("UPDATE ACP SET blockads= :block WHERE vsdnc= 1");
		$result = $statement->execute(array('block' => $newable));
	}
	
	if(isset($_GET['delete'])) {
		$item = $_GET['delete'];
						global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM ACP WHERE vsdnc = 1");
		$result = $statement->execute();
		$user2 = $statement->fetch();
		if(isset($error)) {
			echo $error;
		}
		$words = $user2['blockads'];
		echo $words;
		$replaceable = $_GET['delete'] . ",";
		if (strpos($words, $replaceable) !== false) {
		$newable = str_replace($replaceable, "", $words);
		} else {
		$replaceable = $_GET['delete'];
		$newable = str_replace($replaceable, "", $words);
		}
		$statement = $pdo->prepare("UPDATE ACP SET blockads= :block WHERE vsdnc= 1");
		$result = $statement->execute(array('block' => $newable));
	}

	function echoWords() {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM ACP WHERE vsdnc = 1");
		$result = $statement->execute();
		$user2 = $statement->fetch();
		if(isset($error)) {
			echo $error;
		}
		if($user2 == null || $user2['blockads'] == "") {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Keine W&oumlrter eingetragen!</i></div></div></center>";
		}else {
		$words = $user2['blockads'];
		$splitted = explode(",", $words);
		
		foreach($splitted as $s) {
			if($s == "NULL") continue;
			echo '<div class="card grey darken-3 white-text">
			<div class="card-content white-text">
			<span class="card-title">' . $s .'</span>
			<div class="right">
				<a href="?go=ads&delete=' . $s . '"class="btn-floating btn-large red"><i class="material-icons">remove</i></a>
				</div>
			</div></div> <br \> <br \>';
		}
		}
	}

?>

<div class="card">
<div class="card-content">
<span class="card-title"><center>Alle blacklisted Werbungen</center></span>
<br \>
<form action="?go=ads&do=add&update=true" method="post">
			 <div class="input-field col s6">
          Neue Werbung:
		  <input name="word" id="word" type="text" class="validate">
          <label for="word"></label>
		<button name="submit" class="btn-floating btn-large red"><i class="material-icons">add</i></button>
		</div>
		<br \>
		<br \>
		</form>
<br \>

<?php echoWords(); ?>
</div>
</div>