<?php
function connect(){
	if(isset($_POST['email-connect']) && $_POST['email-connect']!='' && isset($_POST['pswd-connect']) && $_POST['pswd-connect']!=''){
		session_start();
		$_SESSION['mail']=$_POST['email-connect'];
		$_SESSION['pswd']=$_POST['pswd-connect'];
		header('location: ../view/mail.php');
	}
}
connect();
?>