<?php
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["text"]) && $_POST["name"] != '' && $_POST["email"] != '' && $_POST["text"] != '') {

	// Формируем массив для JSON ответа
    $result = array(
    	'name' => $_POST["name"],
    	'email' => $_POST["email"],
    	'text' => $_POST["text"],
    	'formfile' =>'',

    );
	$mail = new PHPMailer(true);
	try {
		//Server settings
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->CharSet = "utf-8";
		$mail->Host       = 'mail.galera.dp.ua';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'noreply@vip-credit.com.ua';                     // SMTP username
		$mail->Password   = 'zD6cy4bDqt';                               // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		//Recipients
		$mail->setFrom('noreply@vip-credit.com.ua', 'vip-credit.com.ua');
		$mail->addAddress('paliipavel@gmail.com', 'Paliy');     // Add a recipient
		$mail->addAddress('majestica7@gmail.com', 'Zhuk');     // Add a recipient
		// Attachments
		if($_FILES['formfile']['error'] === 0){
			if($_FILES['formfile']['size'] > 5000000){
				echo 'bigsize';
				die;
			} else if(preg_match("/jpeg/", $_FILES['formfile']['type']) === 0 && preg_match("/png/", $_FILES['formfile']['type']) === 0 &&  preg_match("/gif/", $_FILES['formfile']['type']) === 0 &&   preg_match("/pdf/", $_FILES['formfile']['type']) === 0 && preg_match("/zip/", $_FILES['formfile']['type']) === 0){
				echo 'wrongtype';
				die;
			} else {
				$target_file = $_SERVER['DOCUMENT_ROOT']."/uploads/".$_FILES['formfile']['name'];
				move_uploaded_file($_FILES["formfile"]["tmp_name"], $target_file);
				$mail->addAttachment($target_file);// Add attachments
				$result['formfile'] = 'ok';
			}
		}


		// Content
		//$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Сообщение от посетителя сайта';
		$mail->Body    = "ФИО: ".$_POST['name'].PHP_EOL."E-mail: ".$_POST['email'].PHP_EOL."Сообщение: ".$_POST['text'];


		$mail->send();
		if (isset($target_file) && file_exists($target_file)) {
			unlink($target_file);
		}
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

    // Переводим массив в JSON
    echo json_encode($result);
}

?>
