<style>
.middle {
    width: 1200px;
    height: 100px;

    position: absolute;
    top: 0;
    bottom: 200;
    left: 0;
    right: 0;

    margin: auto;
	}
</style>
<div class="middle">
<center>
<div class="row">
<div class="col s12 m6 l4 offset-m3 offset-l4">
<div class="card-panel white">
<?php 
if(isset($errorMessage)) {
 echo $errorMessage;
}
?>
<form action="?login=1" method="post">
Benutzername:<br>
<input type="text" size="40" maxlength="250" name="user"><br><br>
 
Passwort:<br>
<input type="password" size="40"  maxlength="250" name="password"><br>
<input type="submit" value="Anmelden" class="grey darken-3 white-text waves-light btn">
</form> 
</div></div></div>
</div>
</center>