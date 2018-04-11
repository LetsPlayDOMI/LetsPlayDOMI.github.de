<?php 
	include "config.php";
	session_start();
	global $dataHost;
	global $dataUser;
	global $dataPass;
	global $dataDatabase;
	$user = isset($_SESSION['user']) ? $_SESSION['user'] : "NAN";
	$superadmin = isset($_SESSION['admin']) ? $_SESSION['admin'] : "NEIN";
	$go = isset($_GET['go']) ? $_GET['go'] : "home";
	
	if($user == "NAN" && !$_GET['redirectonce'] && !$_GET['login']) {
		
		header("Location: ?go=login&redirectonce=true");
	}
	
	if(isset($_GET['login'])) {
		$pdo = new PDO('mysql:host=' . $dataHost . ';dbname=' . $dataDatabase, $dataUser, $dataPass);
		$usernamea = $_POST['user'];
		$passwort = $_POST['password'];
 
		$statement = $pdo->prepare("SELECT * FROM LOGIN WHERE user = :usernamea");
		$result = $statement->execute(array('usernamea' => $usernamea));
		$user2 = $statement->fetch();

		if ($user2 !== false && $passwort == $user2['password']) {
			$_SESSION['user'] = $user2['user'];
			if($user2['permissions'] == "superadmin") {
				$_SESSION['admin'] = $user2['user'];
			}
			echo($user2['user']);
			header("Location: ?go=dashboard");
			} else {
			$errorMessage = "<div class=\"card-panel red lighten-2\">Der Login ist fehlgeschlagen!</div>";
		}
	}	
?>

<html> 
<header>
<link rel="stylesheet" href="stylesheet.css">
	<title>Admin Control Panel</title> 
   	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   	<link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
	      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
		<?php if($user != "NAN") {?>
	<nav>
		<div class="nav-wrapper grey darken-3">
			<ul class="left hide-on-med-and-down">
				<li><a href="?go=dashboard">Dashboard</a></li>
				<li><a href="?go=bans">Bans</a></li>
				<li><a href="?go=mutes">Mutes</a></li>
				<li><a href="?go=serverping">MOTD / Spielerbegrenzung</a></li>
				<li><a href="?go=blacklist">Wortsperre</a></li>
				<li><a href="?go=ads">Werbungssperre</a></li>
				<li><a href="?go=blockedcmds">Commandsperre</a></li>
				<?php 
				if($useChatLogAdminPanel) { echo '<li><a href="?go=chatlogs">ChatLogs</a></li>'; }
				?>
			</ul>
			<ul class="right hide-on-med-and-down">
				<li><a href="?go=usermanagement">Benutzerverwaltung</a></li>
				<li><a href="?go=logout">Abmelden</a></li>
			</ul>
		</div>
	</nav>
	<?php } else {?>
		<nav>
		<div class="nav-wrapper grey darken-3">
		<ul class="left hide-on-med-and-down"><li><a>Admin Control Panel</a></li></ul>
		
			<ul class="right hide-on-med-and-down">
				<li><a href="?go=login">Anmeldung ben&oumltigt</a></li>
			</ul>
		</div>
	</nav>
	<?php }?>
</header> 

<body style="background: url(bg.png) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  opacity:0.99;" >

	  <?php if($user == "NAN") { 
	  require_once("login.php"); 
	  } 
	  else 
	  {
		switch($go) {
			case "dashboard" : require_once("dashboard.php"); break;
			case "serverping" : require_once("serverping.php"); break;
			case "blacklist" : require_once("blacklist.php"); break;
			case "bans" : require_once("bans.php"); break;
			case "mutes" : require_once("mutes.php"); break;
			case "ads" : require_once("ads.php"); break;
		  	case "blockedcmds" : require_once("blockedcmds.php"); break;
			case "login" : require_once("login.php"); break;
			case "logout" : require_once("logout.php"); break;
			case "permissiondeny" : require_once("permissiondeny.php"); break;
			case "editban" : require_once("editban.php"); break;
			case "editmute" : require_once("editmute.php"); break;
			case "usermanagement" : require_once("usermanagement.php"); break;
			case "chatlogs" : require_once("chatlogadmin.php"); break;
			case "editlog" : require_once("editlog.php"); break;
			case "ban" : require_once("ban.php"); break;
			case "mute" : require_once("mute.php"); break;
			default : require_once("dashboard.php"); break;
		}
	  }?>
</body>

<footer>
</footer>
</html>