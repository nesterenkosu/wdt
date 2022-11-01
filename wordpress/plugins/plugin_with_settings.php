<?php
/*
	Plugin name: Плагин с настройками v2
	Author: Я
*/
//Добавление пункта в главное меню
add_action("admin_menu","my_admin_menu");

function my_admin_menu() {
	//Регистрация страницы, на которой будут отображаться настройки
	add_options_page(
		//Заголовок (title) страницы
		"Настройки плагина с настройками",
		//Заголовок пункта меню
		"Настройки плагина с настройками",
		//Необходимые права доступа
		"manage_options",
		//Идентификатор меню
		"pws-options",
		//Функция, реализующая вывод страницы настроек
		"my_settings_page"
	);
}

function my_settings_page() {
	//Если была нажата кнопка "Сохранить"
	if(isset($_POST["btn_Save"])) {
		//Сохранение настроек
		update_option("opt_greeting",$_POST["opt_greeting"]);
		update_option("opt_color",$_POST["opt_color"]);
		//echo "<pre>";print_r($_POST);echo "</pre>";
	}
	
	//Считывание значений, выводимых в форме по умолчанию
	$greeting=get_option("opt_greeting");
	$color=get_option("opt_color");	
?>
<h1>Настройки плагина с настройкми</h1>
<form action="" method="POST">
Текст приветствия:
<input name="opt_greeting" type="text" size="15" value="<?=$greeting?>"/>
Цвет:
<select name="opt_color">
	<option <?=v(1,$color)?>>Красный</option>
	<option <?=v(2,$color)?>>Зелёный</option>
	<option <?=v(3,$color)?>>Синий</option>
</select>

<p class="description">
Плагин, выводящий приветствие под каждой записью
</p>

<p class="submit">
	<input name="btn_Save" type="submit" value="Сохранить" class="button button-primary"/>
</p>
</form>
<?
}

function my_filter($content) {
	$greeting=get_option("opt_greeting");
	$color=get_option("opt_color");
	//die("color=[".$color."]");		
	switch($color){
		case "1": {$color="red";break;}
		case "2": {$color="green";break;}
		case "3": {$color="blue";break;}
	}
	
	return $content.'<center><font color="'.$color.'">'.$greeting."</font></center>";
}

add_filter("the_content","my_filter");

function v($v,$f) {
	return 'value="'.$v.'" '.(($v==$f)?'selected':'');
}
