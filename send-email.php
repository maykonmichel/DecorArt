<?php

	session_start();

	$_SESSION['delivery-address'] = 
		$_POST['address'].", ".$_POST['number']." - ".$_POST['neighborhood'].", ".$_POST['city']." - ".strtoupper($_POST['state']);
	echo '
		<script type="text/javascript">
			window.open("http://200.145.153.175/maykonpalma/begahmays/decorart/checkout.php", "_self");
			window.open("http://200.145.153.175/maykonpalma/begahmays/decorart/create-pdf.php", "_blank");
		</script>
	';

	require 'phpmailer/PHPMailerAutoload.php';
	
	$mail = new PHPMailer;
	
	$mail->SMTPDebug = 2;
	$mail->Debugoutput = 'html';
	
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	
	$mail->Username = "begahmays.decorart@gmail.com";
	$mail->Password = "maykaodlc";

	$mail->setFrom('begahmays.decorart@gmail.com', 'DecorArt LTDA');
	$mail->addReplyTo('begahmays.decorart@gmail.com', 'DecorArt LTDA');
	$mail->addAddress($_SESSION['email'], $_SESSION['']);
	
	$mail->Subject = 'Compra Finalizada';
	$mail->msgHTML(file_get_contents('mail-content.php'), dirname(__FILE__));
	//$mail->addAttachment('teste.pdf');
	$mail->send();

?>