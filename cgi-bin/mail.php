<?php
ini_set('display_errors', 0);

if (!isset($_POST['banner-form__field-name']) || !isset($_POST['banner-form__field-phone'])) {
	http_response_code(400);
	echo 'Ошибка запроса :(';
	exit;
}
else if (!preg_match("/^\+?[1-9\(\)\-]+/", $_POST['banner-form__field-phone'])) {
	http_response_code(400);
	echo 'Ошибка параметров запроса :(';
	exit;
}
else if (strlen($_POST['banner-form__field-name']) < 2 || strlen($_POST['banner-form__field-name']) > 50) {
	http_response_code(400);
	echo 'Ошибка параметров запроса :(';
	exit;
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../lib/phpmailer/Exception.php';
require '../lib/phpmailer/PHPMailer.php';
require '../lib/phpmailer/SMTP.php';

try {
	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	//Set who the message is to be sent from
	$mail->setFrom('cl121456@vh358.timeweb.ru', 'cl121456');
	//Set who the message is to be sent to
	$mail->addAddress('sergey-gek@mail.ru');

	$mail->CharSet = 'UTF-8';

	//Content
	$mail->isHTML(true); //Set email format to HTML
	$mail->Subject = 'Запрос через форму обратной связи';
	$mail->Body = "
	<p>Поступил запрос через форму обратной связи!</p>
	<h3>Данные клиента</h3>
	<p>Имя: {$_POST['banner-form__field-name']}</p>
	<p>Телефон: {$_POST['banner-form__field-phone']}</p>
	";

	$mail->send();
	echo 'Сообщение отправлено!';
}
catch (Exception $e) {
	http_response_code(500);
	echo "Ошибка при отправке сообщения :(";
	exit;
}