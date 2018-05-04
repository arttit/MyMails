<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>My Emails</title>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-" crossorigin="anonymous">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="stylesheet" href="css/email.css">
</head>
<body>
	<div class="form-connect">
		<form class="pure-form" method="POST" action="../model/confirm_connect.php">
	    	<fieldset>
	       		<legend id="txt-legend-form">My Emails :</legend>
	       		<h3 class="txt-form-connect">Connexion : </h3>
	       		<div class="email-form-connect">
			        <label for="email">Email</label><br/>
		        	<input id="email" type="email" name="email-connect" placeholder="Email">
		        </div>
		        <div class="pswd-form-connect">
		        	<label id="txt-pswd-form-connect" for="password">Password</label><br/>
		        	<input id="password" type="password" name="pswd-connect" placeholder="Password">
		        </div>
				<button id="submit-btn-form-connect" type="submit" class="pure-button pure-button-primary">Sign in</button>
		    </fieldset>
		</form>
	</div>
</body>
</html>