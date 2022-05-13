<?php
	header("Access-Control-Allow-Origin: *");
	echo json_encode(Array(
		Array(
			"value"=>1,
			"caption"=>"Odin"
		),
		Array(
			"value"=>2,
			"caption"=>"Dva"
		),
		Array(
			"value"=>3,
			"caption"=>"Tri"
		),
	));
	