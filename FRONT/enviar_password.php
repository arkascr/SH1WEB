<?php
if (isset($_GET['email'])) {

	// Dirección del destinatario
	$to = $_GET['email'];
	
	$emailExitoso = $usuario->buscarUsuario($to);

	if ($emailExitoso == false) {
		$error = "El correo electrónico no existe.";
		exit();
	} 

	$token = bin2hex(random_bytes(20));
	$resetLink = "http://localhost/reset_password.php?token=" . $token;

	// Asunto del correo
	$subject = 'Recuperar contraseña';

	// Mensaje del correo
	$message = '<html>
	<head>
	  <title>Recuperar contraseña</title>
	</head>
	<body>
	<p> Haz click para generar nueva contraseña</p>
	<a href="'.$resetLink.'">Ir</a>
	';

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Encabezados del correo
	$headers = 'From: pablo.sena@tagtico.com' . "\r\n" .
			   'Reply-To: tu_correo@gmail.com' . "\r\n" .
			   'X-Mailer: PHP/' . phpversion();

	// Enviar el correo
	if(mail($to, $subject, $message, $headers)) {
		echo 'Correo enviado con éxito';
	} else {
		echo 'Error al enviar el correo';
	}
}
?>
