<?php

include 'src/Matriz.php';

function calcular($params)
{		
	$m = new \CursoPHP\API\Matriz();
	return $m->calcular($params);		
}

try 
{	
	if (isset($_POST) && !empty($_POST))
		$response = calcular($_POST);	
}
catch (\Exception $ex)
{
	$errors[] = sprintf('Error: %s', $ex->getMessage());
}

//Exibe a página
require 'src/view/matriz.phtml';