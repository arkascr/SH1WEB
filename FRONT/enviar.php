<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $name = htmlspecialchars($_POST['name']);
    $subject = htmlspecialchars($_POST['subject']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Dirección de correo electrónico de destino
    $to = "bravo1m12@gmail.com"; // Cambia esta línea por la dirección de correo electrónico a la que quieres enviar los datos
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Asunto del correo
    $mail_subject = "Nuevo mensaje de contacto: $subject";

    // Cuerpo del correo
    $mail_body = "<h2>Nuevo mensaje de contacto</h2>
                  <p><strong>Nombre:</strong> $name</p>
                  <p><strong>Email:</strong> $email</p>
                  <p><strong>Mensaje:</strong><br>$message</p>";

    // Enviar el correo
    if (mail($to, $mail_subject, $mail_body, $headers)) {
        echo "El mensaje se ha enviado correctamente.";
    } else {
        echo "Hubo un error al enviar el mensaje. Por favor, inténtelo de nuevo.";
    }
}
?>
