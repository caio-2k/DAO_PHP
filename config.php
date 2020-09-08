<?php 

spl_autoload_register(function($class_name){

	//informando a localização das classes (na pasta class)
	$filename = "class".DIRECTORY_SEPARATOR.$class_name.".php";

	if (file_exists(($filename))) {
		require_once($filename);
	}

});

 ?>