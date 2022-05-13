<?php require_once("$_SERVER[DOCUMENT_ROOT]/../db/common.dal.inc.php");

//CRUD - Create Read Update Delete
//Создание нового пользователя (Create)
function DBCreateUser($Name,$Email,$Age) {
	//Предотвращение SQL-инъекций
	$Name=_DBEscString($Name);
	$Email=_DBEscString($Email);
	$Age=(int)$Age;
	
	//Выполнение запроса к БД
	_DBQuery("
		INSERT INTO Users(Name,Email,Age)
		VALUES ('$Name','$Email','$Age')
	");
}

//Получение одного пользователя (Read)
function DBGetUser($id) {
	//Предотвращение SQL-инъекций
	$id=(int)$id;
	//Выполнение запроса
	return _DBGetQuery("SELECT * FROM users WHERE ID=$id");
}

//Получение списка пользователей (Read)
function DBFetchUsers() {
	//Выполнение запроса
	return _DBFetchQuery("SELECT * FROM Users");
}

//Подсчёт общего числа пользователей в базе (Read)
function DBCountAllUsers() { 
	return _DBRowsCount(_DBQuery("SELECT * from Users"));
}

//Редактирование элемента (Update)
function DBUpdateUser($id,$Name,$Email,$Age) {
	//Предотвращение SQL-инъекций
	$id=(int)$id;
	$Name=_DBEscString($Name);
	$Email=_DBEscString($Email);
	$Age=(int)$Age;
	
	//Выполнение запроса	
	_DBQuery("
		UPDATE Users 
		SET	Name='$Name',
			Email='$Email',
			Age='$Age'
		WHERE 
			ID=$id
	");
}

//Удаление элемента (Delete)
function DBDeleteUser($id) {
	//Предотвращение SQL-инъекций
	$id=(int)$id;
	
	//Выполнение запроса
	_DBQuery("DELETE FROM Users WHERE id=$id");
}
