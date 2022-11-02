<?php
/*
	Plugin name: Подсчёт просмотров записей v2
	Author: Me
*/

/*
	Добавлено предотвращение накрутки счётчика просмотров одним и тем же пользователем
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
	
	$wpdb->query("
		CREATE TABLE ml_WhoViewed(
			`ID` INT NOT NULL AUTO_INCREMENT,
			`PostID` INT NOT NULL,				
			`UserID` INT NOT NULL,				
			PRIMARY KEY(`ID`)
		) ENGINE=InnoDB
	");
}

function ml_uninstall() {
	global $wpdb;
	
	$wpdb->query("DROP TABLE ml_Views");
	$wpdb->query("DROP TABLE ml_WhoViewed");
}
register_activation_hook(__FILE__,"ml_install");
register_deactivation_hook(__FILE__,"ml_uninstall");

function count_views($content) {
	global $wpdb;
	
	$post_id=get_the_ID();
	$user_id=get_current_user_id();
	
	$view=$wpdb->get_row("SELECT ViewCount FROM ml_Views WHERE PostID=$post_id");
		
	if($wpdb->num_rows==0)
		$count=0;
	else
		$count=$view->ViewCount;
	
	//Получение информации о том, была ли данная запись
	//уже просмотрена текущим пользователем
	$wpdb->get_row("SELECT * FROM ml_WhoViewed WHERE PostID=$post_id AND UserID=$user_id");
	
	//Если текущий пользователь ещё не просматривал
	//данную запись - изменим количество просмотров
	if($wpdb->num_rows==0) {
		//Занесём id текущего пользователя
		//в таблицу ml_WhoViewed
		$wpdb->query("
				INSERT INTO 
				ml_WhoViewed(PostID,UserID)
				VALUES($post_id,$user_id)			
			");
			
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
	}
	
	return $content."<br/>Просмотров ($count)<br/>";
}
add_filter("the_content","count_views");
