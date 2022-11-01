<?php
/*
	Plugin name: Демонстрация шорткодов Wordpress
	Author: Me 
*/
function demo_short($attrs,$content) {
	return "
	<h1>Hello $attrs[username]!</h1>
	<hr/>
	<h2>Этот текст был в содержимом</h2>
	<center><font color='red'>$content</font></center>
	<hr/>
";
}
add_shortcode("demoshort","demo_short");

function demo_short_2($attrs,$content) {
	$table_rows="";
	foreach($attrs as $key=>$value) {
		$table_rows.="
		<tr>
			<td>$key</td>
			<td>$value</td>
		</tr>
		";
	}
	return "
	<table border='1'>
		<tr>
			<th>Атрибут</th>
			<th>Значение</th>
		</tr>
		$table_rows
		<tr>
			<td colspan='2'><b>Текст внутри тега</b></td>
		</tr>
		<tr>
			<td colspan='2'>$content</td>
		</tr>
	</table>
";
}
add_shortcode("demoshort2","demo_short_2");

//-----------------------------
//Реализация кнопок на панели инструментов текстового редактора TinyMCE
function register_my_button($buttons) {
	//регистрация новой кнопки
	//$buttons - список кнопок, уже существующих в редакторе
	array_push($buttons,"demobutton");
	return $buttons;
}
add_filter("mce_buttons","register_my_button"); 

function add_js($opt){
	//Подключение файла с js-кодом
	$opt["demobutton"]=plugins_url("scripts/script.js",__FILE__);
	return $opt;
}
add_filter("mce_external_plugins","add_js");
