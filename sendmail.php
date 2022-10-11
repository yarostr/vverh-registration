<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('strelnikov2302.8@gmail.com', 'Слово Жизни Балаково');
	//Кому отправить
	$mail->addAddress($_POST['email']);
	$mail->addAddress('vverh@etlgr.com');
	//Тема письма
	$mail->Subject = 'Регистрация на конференцию ВВЕРХ22';

	//Дата приезда
	$date = "6 Января";
	if($_POST['date'] == "SevenJanuary"){
		$date = "7 Января";
	}
	if($_POST['date'] == "EightJanuary"){
		$date = "8 Января";
	}
	if($_POST['date'] == "NineJanuary"){
		$date = "9 Января";
	}
	// Я хочу посетить пророческую комнату
	$room = "Да";
	if($_POST['room'] == "formRoomNo"){
		$room = "нет";
	}
	// расселение
	$resettlement = "Да";
	if($_POST['resettlement'] == "formresettlementNo"){
		$resettlement = "нет";
	}
	// Рандомное число для участника
	$random = rand(0, 100) + rand(0, 100) + rand(0, 100) + 1000;
	//Тело письма
	$body = '<h1>Вы успешно зарегистрировались на конференцию ВВЕРХ22, скоро мы свяжемся с Вами</h1>';
	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	}
	if(trim(!empty($_POST['surName']))){
		$body.='<p><strong>Фамилия:</strong> '.$_POST['surName'].'</p>';
	}
	if(trim(!empty($_POST['phone']))){
		$body.='<p><strong>Номер телефона:</strong> '.$_POST['phone'].'</p>';
	}
	if(trim(!empty($_POST['age']))){
		$body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
	}
	if(trim(!empty($_POST['Country']))){
		$body.='<p><strong>Страна:</strong> '.$_POST['Country'].'</p>';
	}
	if(trim(!empty($_POST['сity']))){
		$body.='<p><strong>Город:</strong> '.$_POST['сity'].'</p>';
	}
	if(trim(!empty($_POST['church']))){
		$body.='<p><strong>Церковь:</strong> '.$_POST['church'].'</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
	}
	if(trim(!empty($_POST['date']))){
		$body.='<p><strong>Дата приезда:</strong> '.$date.'</p>';
	}
	if(trim(!empty($_POST['resettlement']))){
		$body.='<p><strong>Расселение:</strong> '.$resettlement.'</p>';
	}
	if(trim(!empty($_POST['room']))){
		$body.='<p><strong>Я хочу посетить пророческую комнату:</strong> '.$room.'</p>';
	}
	$body.='<p><strong>Цвет вашего браслета:</strong> Оранжевый</p>';
	$body.='<p><strong>Ваш номер:</strong>'.$random.'</p>';
	$body.='<p><strong>Ссылка целевого пожертвования:</strong> https://vk.com/yarost20 </p>';

	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Фото в приложении</strong>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Спасибо за регистрацию!
Cсылка на целевое пожертование прийдет на почту.
Если письмо не пришло, проверьте спам!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>