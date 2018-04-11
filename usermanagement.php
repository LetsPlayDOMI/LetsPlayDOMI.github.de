<?php 
	
			global $user;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM LOGIN WHERE user= :user");
		$result = $statement->execute(array('user' => $user));
		$user3 = $statement->fetch();
		if (strpos($user3['permissions'], "VERWALTUNG") == false) {
			header("Location: ?go=permissiondeny");
		}
	
	if(isset($_GET['edit'])) {
		header("Location: ?useredit=" . $_GET['edit']);
	}
	
	if(isset($_GET['delete'])) {
		$username = $_GET['delete'];
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);

		$statement = $pdo->prepare("DELETE FROM LOGIN WHERE user= :user");
		$result = $statement->execute(array('user' => $username));
	}
	if(isset($_GET['do']) && $_GET['do'] == "add") {
		$username = $_POST['word'];
		$passwd = $_POST['password'];
		$bans = $_POST['bans'];
		$mutes = $_POST['mutes'];
		$motd = $_POST['motd'];
		$verwaltung = $_POST['verwaltung']; 
		$wort = $_POST['wort'];
		$werbung = $_POST['werbung'];
		$command = $_POST['command'];
		$chatlog = $_POST['chatlog'];
		if($username == "" || $username == " " || $passwd == "" || $passwd == " ") {
			
		} else {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$permissions = "PERMISSIONS: ";
		if (strpos($bans, "on") !== false) {
			$permissions = $permissions . "BANS";
		}
		if (strpos($mutes, "on") !== false) {
			$permissions = $permissions . " ";
			$permissions = $permissions . "MUTES";
		}
		if (strpos($motd, "on") !== false) {
			$permissions = $permissions . " ";
			$permissions = $permissions . "MOTD";
		}
		if (strpos($verwaltung, "on") !== false) {
			$permissions = $permissions . " ";
			$permissions = $permissions . "VERWALTUNG";
		}
		if (strpos($wort, "on") !== false) {
			$permissions = $permissions . " ";
			$permissions = $permissions . "WORT";
		}
		if (strpos($werbung, "on") !== false) {
			$permissions = $permissions . " ";
			$permissions = $permissions . "WERBUNG";
		}
		if (strpos($command, "on") !== false) {
			$permissions = $permissions . " ";
			$permissions = $permissions . "COMMAND";
		}
		if (strpos($chatlog, "on") !== false) {
			$permissions = $permissions . " ";
			$permissions = $permissions . "CHATLOG";
		}
		if($permissions == "PERMISSIONS: ") {
			$permissions = "KEINE";
		}
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM LOGIN WHERE user= :user");
		$result = $statement->execute(array('user' => $username));
		$user2 = $statement->fetchAll();
		if($user2 == null) {
		$statement = $pdo->prepare("INSERT INTO LOGIN (user, password, permissions) VALUES (:user, :password, :permissions);");
		$result = $statement->execute(array('user' => $username, 'password' => $passwd, 'permissions' => $permissions));
		}
		}
	}
	
	function echoUsers() {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM LOGIN");
		$result = $statement->execute();
		$user2 = $statement->fetchAll();
		if($user2 == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Keine Benutzer eingetragen!</i></div></div></center>";
		}else {
		
		foreach($user2 as $s) {
			if($s == "NULL") continue;
			echo '<div class="card grey darken-3 white-text">
			<div class="card-content white-text">
			<span class="card-title">' . $s['user'] .'</span>
			<p class="floating-text">' . $s['permissions'] . '</p>
			<div class="right">
				<a href="?go=usermanagement&delete=' . $s['user'] . '"class="btn-floating btn-large red"><i class="material-icons">remove</i></a>
				</div>
			</div></div> <br \> <br \>';
		}
		}
	}

?>

<div class="row">
<div class="card">
<div class="card-content">
<center><span class="card-title">Benutzerverwaltung</span>
<p>Achtung: Wenn du einen Admin Account entfernst, hast du nicht mehr den vollen Zugriff auf alle Funktionen.</p>
<center><form action="?go=usermanagement&do=add" method="post">
	<div class="col s3">
	</div>
			 <div class="input-field col s6">
          Neuer Benutzer:
		  <br \>
		  <br \>
		  Benutzername:
		  <input name="word" id="word" type="text" class="validate">
          <label for="word"></label>
		  		  <br \>
		  Password:
		  <input name="password" id="password" type="password" class="validate">
          <label for="password"></label>
		<div class="col s12">
				  		Permissions:
		</div>
		<div class="col s6">
		<center><p>
		<input type="checkbox" name="bans" id="bans"/>
		<label for="bans">Bans ansehen / bearbeiten / l&oumlschen</label>
		</p>
				    <p>
		<input type="checkbox" name="mutes" id="mutes"/>
		<label for="mutes">Mutes ansehen / bearbeiten / l&oumlschen</label>
		</p>
						    <p>
		<input type="checkbox" name="motd" id="motd"/>
		<label for="motd">Motd & Spieler maximum anzeigen / bearbeiten</label>
		</p>
						<p>
		<input type="checkbox" name="verwaltung" id="verwaltung"/>
		<label for="verwaltung">Benutzerverwaltung anzeigen / bearbeiten</label>
		</p>
		</div>
		<div class="col s6">
		<center>
		<p>
		<input type="checkbox" name="wort" id="wort"/>
		<label for="wort">Wort-Blacklist anzeigen / bearbeiten / l&oumlschen</label>
		</p>
		<p>
		<input type="checkbox" name="werbung" id="werbung"/>
		<label for="werbung">Werbungs-Blacklist anzeigen / bearbeiten / l&oumlschen</label>
		</p>
				<p>
		<input type="checkbox" name="command" id="command"/>
		<label for="command">Command-Blacklist anzeigen / bearbeiten / l&oumlschen</label>
		</p>
						<?php if($useChatLogAdminPanel == true) {?>
						<p>
		<input type="checkbox" name="chatlog" id="chatlog"/>
		<label for="chatlog">ChatLogs anzeigen / bearbeiten / l&oumlschen</label>
		</p>
						<?php } ?>
		</div>
		</div>
		<div class="col s12">
				<br \>
				<button name="submit" class="btn-floating btn-large red"><i class="material-icons">add</i></button>
		</div>
				<br \>
		<br \>
				<br \>
						  		<br \>
		<br \>
				<br \>
		<br \>
						  		<br \>
		<br \>
				<br \>
		<br \>
		<br \>
				<br \>
		<br \>
				<br \>
		<br \>
		</form>
		</center>
						<br \>
		<br \>
		
				<br \>
		<br \>
</center>
<?php echoUsers(); ?>
</div>
</div>
</div>