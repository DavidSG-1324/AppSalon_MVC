<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

	public $nombre;
	public $email;
	public $token;

	public function __construct($nombre, $email, $token)
	{
		$this -> nombre = $nombre;
		$this -> email = $email;
		$this -> token = $token;		
	}

	public function enviarConfirmacion() {

		// Crear instancia de PHPMailer
		$mail = new PHPMailer();

		// Configurar SMTP, protocolo de envío de email
		$mail -> isSMTP();
		$mail -> SMTPAuth = true;
		$mail -> SMTPSecure = 'tls';
		$mail -> Host = 'smtp.mailtrap.io';
		$mail -> Port = 2525;
		$mail -> Username = '47ab855183d3bd';
		$mail -> Password = 'cbbde6e4d43107';

		// Configurar contenido del encabezado
		$mail -> setFrom('cuentas@appsalon.com');
		$mail -> addAddress('cuentas@appsalon.com', 'AppSalon.com');
		$mail -> Subject = 'Confirma tu Cuenta';

		// Habilitar HTML
		$mail -> isHTML(true);
		$mail -> CharSet = 'UTF-8';

		// Definir contenido del email
		$contenido = "<html>";
		$contenido .= "<p>Hola <strong>" . $this -> nombre . "</strong>, has creado tu cuenta en AppSalon, para terminar el registro sólo debes hacer Click en el siguiente enlace:</p>";
		$contenido .= "<p><a href='http://localhost:5000/confirm-account?token=". $this -> token ."'>Confirmar Cuenta</a></p>";
		$contenido .= "<p>Si no creaste la cuenta puedes ignorar este mensaje.</p>";
		$contenido .= "</html>";

		$mail -> Body = $contenido;
		
		$mail -> AltBody = "Mensaje de confirmación";
		
		// Enviar email
		$mail -> send();
	}

	public function enviarInstrucciones() {
		$mail = new PHPMailer();

		$mail -> isSMTP();
		$mail -> SMTPAuth = true;
		$mail -> SMTPSecure = 'tls';
		$mail -> Host = 'smtp.mailtrap.io';
		$mail -> Port = 2525;
		$mail -> Username = '47ab855183d3bd';
		$mail -> Password = 'cbbde6e4d43107';

		$mail -> setFrom('cuentas@appsalon.com');
		$mail -> addAddress('cuentas@appsalon.com', 'AppSalon.com');
		$mail -> Subject = 'Recupera tu Cuenta';

		$mail -> isHTML(true);
		$mail -> CharSet = 'UTF-8';

		$contenido = "<html>";
		$contenido .= "<p>Hola <strong>" . $this -> nombre . "</strong>, para recuperar tu cuenta sólo debes reestablecer tu Password haciendo Click en el siguiente enlace:</p>";
		$contenido .= "<p><a href='http://localhost:5000/recover?token=". $this -> token ."'>Recuperar Cuenta</a></p>";
		$contenido .= "<p>Si no solicitaste el cambio puedes ignorar este mensaje.</p>";
		$contenido .= "</html>";

		$mail -> Body = $contenido;
		
		$mail -> AltBody = "Mensaje de confirmación";
		
		$mail -> send();
	}
}

