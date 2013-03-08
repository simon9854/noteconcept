<?php
function chargerClass($class){
	if(file_exists('./class/'.$class .'.class.php')){
		require './class/'.$class .'.class.php';
	}
	else{
		require './manager/'.$class.'.class.php';
	}
}

function chargerModuleForm($form){
	require '/module/form_jquery/'.$form .'.php';
}

spl_autoload_register('chargerClass');
spl_autoload_register('chargerModuleForm');
?>