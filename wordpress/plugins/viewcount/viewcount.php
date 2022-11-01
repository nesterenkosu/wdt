<?php
/*
	Plugin name: Подсчёт просмотров записей
	Author: Me
*/

//Обработчик события активации плагина
function ml_install() {
	global $wpdb;
	
	$wpdb->query("
		CREATE TABLE ml_Views(
			`ID` INT NOT NULL AUTO_INCREMENT,
			`PostID` INT NOT NULL,
			`ViewCount` INT NOT NULL,
			PRIMARY KEY(`ID`)
		) ENGINE=InnoDB
	");
}
register_activation_hook(__FILE__,"ml_install");

function count_views($content) {
	global $wpdb;
	
	$post_id=get_the_ID();
	
	$view=$wpdb->get_row("SELECT ViewCount FROM ml_Views WHERE PostID=$post_id");
		
	if($wpdb->num_rows==0)
		$count=0;
	else
		$count=$view->ViewCount;
	
	if($count==0) {
		//Первый просмотр записи		
		$wpdb->query("
			INSERT INTO 
			ml_Views(PostID,ViewCount)
			VALUES($post_id,1)			
		");
	}else{
		$wpdb->query("
			UPDATE ml_Views
			SET `ViewCount`=`ViewCount`+1
			WHERE PostID=$post_id
		");
	}
	
	return $content."<br/>Просмотров ($count)<br/>";
}
add_filter("the_content","count_views");