<br \>
<br \>
<br \>

<?php 

		global $user;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM LOGIN WHERE user= :user");
		$result = $statement->execute(array('user' => $user));
		$user3 = $statement->fetch();
		if (strpos($user3['permissions'], "MOTD") == false) {
			header("Location: ?go=permissiondeny");
		}

	echoServerping();
	
	if(isset($_GET['update'])) {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		if($_POST['first'] != "") {
		$statement = $pdo->prepare("UPDATE ACP SET motdfirst= :motd WHERE vsdnc= 1");
		$result = $statement->execute(array('motd' => $_POST['first']));	
		}
		if($_POST['second'] != "") {
		$statement = $pdo->prepare("UPDATE ACP SET motdsecond= :motd WHERE vsdnc= 1");
		$result = $statement->execute(array('motd' => $_POST['second']));	
		}
							$error = "<div class=\"card-panel light-green\">Aktualisierung erfolgreich</div>";

		header("Location: ?go=serverping");
	}
	
		if(isset($_GET['update1'])) {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		if($_POST['slots'] != "") {
			try {
			$i = intval($_POST['slots']);
		$statement = $pdo->prepare("UPDATE ACP SET maxplayers= :max WHERE vsdnc= 1");
		$result = $statement->execute(array('max' => $_POST['slots']));
					$error = "<div class=\"card-panel light-green\">Aktualisierung erfolgreich</div>";
			} catch (Exception $ex) {

			}			
		}
		header("Location: ?go=serverping");
	}
	
		function echoServerping() {
		global $dataHost;
		global $dataUser;
		global $dataPass;
		global $dataDatabase;
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$statement = $pdo->prepare("SELECT * FROM ACP WHERE vsdnc= 1");
		$result = $statement->execute();
		$user2 = $statement->fetch();
		if($user2 == null) {
			echo "<center><div class='card grey darken-2 white-text'><div class='card-content white-text'><i>Es ist ein unbekannter Fehler aufgetreten.</i></div></div></center>";
		}
		
		$motd = $user2['motdfirst'];
		$motdsec = $user2['motdsecond'];
		$maxplayers = $user2['maxplayers'];
			if(isset($error)) {
				echo $error;
			}
			echo '<div class="row col s12">
			<div class="card col s5 black-text">
			<div class="card-content black-text">
			<div class="card-content">
			<center><span class="card-title">MOTD:</span><p class="flow-text"> <br \> 1. Zeile der MOTD: ' . $motd . ' <br \> <br \><p class="flow-text">2. Zeile der MOTD: ' .$motdsec . '<br \>
			<br \>
			<br \>
			<form action="?go=serverping&update=true" method="post">
			<div class="row">
		<div class="input-field col s6">
		1. Zeile: (Leer lassen, um keine &Aumlnderungen vorzunehmen)
          <input name="first" id="first" type="text" class="validate">
          <label for="first"></label>
        </div>
		        <div class="input-field col s6">
						2. Zeile: (Leer lassen, um keine &Aumlnderungen vorzunehmen)
          <input name="second" id="second" type="text" class="validate">
          <label for="second"></label>
        </div>
		</div>
		<center><button class="btn large grey darken-3" name="submit">Ping aktualisieren</button><br \> <br \><center><p><center>Je nach Einstellung, ist es M&oumlglich, dass die &Aumlnderungen erst in bis zu einer Minute &uumlbernommen werden.</center>
		</form>
			</div>
			</div>
			</div>
			<div class="col s2">
			</div>
			<div class="card col s5">
			<center><div class="card-content black-text">
			<center><div class="card-content">
			<center><span class="card-title">Slots:</span> <br \><center><p class="flow-text">Derzeitige Slots: ' . $maxplayers . '<br \>
			<br \>
			<br \>
		<center><form action="?go=serverping&update1=true" method="post">
			<div class="row"> 
<div class="input-field col s12">
Neue Slotanzahl:
        <input name="slots" id="slots" type="text" class="validate">
         <label for="slots"></label>
        </div>
					<br \>
			<br \>
						<br \>
			<br \>
			
		</div>
		</center>
					<br \>
			<br \>
		<center><button class="btn large grey darken-3" name="submit">Slots aktualisieren</button><br \> <br \><center><p><center>Je nach Einstellung, ist es M&oumlglich, dass die &Aumlnderungen erst in bis zu einer Minute &uumlbernommen werden.</center>
		</form>
					<br \>
			<br \>
						<br \>
			
			</div>
			</div>
			</div>
			</div>';
	}


?>