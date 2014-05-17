<?php

include '../src/Matriz.php';

use \CursoPHP\API\Matriz as M;

$m = new M();

$feiraSalvador = $m->calcular(['origem' => 'Feira de Santana', 'destino' => 'Salvador']);

$testResults['112.200 metros deve retornar 112 KM'] = 
	$m->toKM(112200) === 112 ? 'PASSOU' : 'FALHOU';

$testResults['Deve retornar um atributo "distancia"'] = 
	isset($feiraSalvador[M::FIELD_DISTANCIA_KM]) ? 'PASSOU' : 'FALHOU';

$testResults['A distância entre Feira e Salvador deve ser maior que 100KM'] = 
	$feiraSalvador[M::FIELD_DISTANCIA_KM] > 100 ? 'PASSOU' : 'FALHOU';

$testResults['A distância entre Feira e Salvador deve ser menor que 150KM'] = 
	$feiraSalvador[M::FIELD_DISTANCIA_KM] < 150 ? 'PASSOU' : 'FALHOU';

$testResults['A distância entre Feira e Salvador deve ser igual à 116KM'] = 
	$feiraSalvador[M::FIELD_DISTANCIA_KM] === 116 ? 'PASSOU' : 'FALHOU';

$feiraSaoPaulo = $m->calcular(['origem' => 'Feira de Santana', 'destino' => 'São Paulo']);

$testResults['A distância entre Feira e São Paulo deve ser maior que 1.000 KM'] = 
	$feiraSaoPaulo[M::FIELD_DISTANCIA_KM] > 1000 ? 'PASSOU' : 'FALHOU';

$testResults['A distância entre Feira e São Paulo deve ser igual à 1.815 KM'] = 
	$feiraSaoPaulo[M::FIELD_DISTANCIA_KM]  == 1815 ? 'PASSOU' : 'FALHOU';

print_r($testResults);


