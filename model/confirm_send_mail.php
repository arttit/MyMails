<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function send_mail(){
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';
	if(isset($_POST['mail_to0']) && isset($_POST['mail_subject']) && isset($_POST['mail_content']) && $_POST['mail_to0']!='' && $_POST['mail_content']!='' && $_POST['mail_subject']!=''){
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->isSMTP();
		$mail->SMTPDebug = 4; 
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);
		session_start();
		$mail->Username = $_SESSION['mail'];
		$mail->Password = $_SESSION['pswd'];
		$mail->SetFrom($_SESSION['mail']);
		if(isset($_POST['mail_to1']) && $_POST['mail_to1'] !='' && $_POST['mail_to1'] != $_POST['mail_to0']){
			$mail->AddAddress($_POST['mail_to1']);
		}
		if(isset($_POST['mail_to2']) && $_POST['mail_to2'] !='' && $_POST['mail_to2'] != $_POST['mail_to0'] && $_POST['mail_to1'] != $_POST['mail_to2']){
			$mail->AddAddress($_POST['mail_to2']);
		}
		if(isset($_POST['mail_to3']) && $_POST['mail_to3'] !='' && $_POST['mail_to3'] != $_POST['mail_to0'] && $_POST['mail_to3'] != $_POST['mail_to1']){
			$mail->AddAddress($_POST['mail_to3']);
		}
		$mail->AddAddress($_POST['mail_to0']);
		$mail->Subject = $_POST['mail_subject'];
		$mail->msgHTML($_POST['mail_content']);
		if (!$mail->Send()){}
		$mail->SmtpClose();
		unset($mail);
	}
}
send_mail();
header('location: ../view/mail.php');
?>