<?php

namespace CursoPHP\API;

class Matriz
{

	const FIELD_ORIGEM  = 'origem';
	const FIELD_DESTINO = 'destino';
	
	const FIELD_DISTANCIA_KM = 'distancia-km';
	const FIELD_DISTANCIA_M  = 'distancia-m';
	const FIELD_DISTANCIA_KM_TEXT = 'distancia-km-text';
	const FIELD_TEMPO 			  = 'tempo';

	const API_URL 		   = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations=%s&language=pt-BR&sensor=false';
	const API_STATUS_OK    = 'OK';
	const API_FIELD_STATUS = 'status';

	private function checkParams($params)
	{
		if (! isset($params[self::FIELD_ORIGEM]) 
			&& ! isset($params[self::FIELD_ORIGEM]))
			throw new \InvalidArgumentException('Parâmetros Inválidos!');			
	}

	public function calcular($params)
	{
		$this->checkParams($params);

		$response = array();		
		$response = $this->getResponse($params);
		return $response;
	}

	private function getResponse($params)
	{
		$response = [self::FIELD_DISTANCIA_M => 0, self::FIELD_DISTANCIA_KM => 0];		

		$origins = urlencode($params[self::FIELD_ORIGEM]);
		$destinations = urlencode($params[self::FIELD_DESTINO]);

		$responseJson = file_get_contents(sprintf(self::API_URL, $origins, $destinations));		

		if (empty($responseJson))
			throw new \UnexpectedValueException('Resposta da API está vazia!');
		
		$responseArray = json_decode($responseJson, true);		
		
		if (! isset($responseArray[self::API_FIELD_STATUS]) || self::API_STATUS_OK != $responseArray[self::API_FIELD_STATUS])
			throw new \UnexpectedValueException(sprintf('Parâmetros Inválidos %s', $responseArray[self::API_FIELD_STATUS]));		

		if (isset($responseArray['rows']) && count($responseArray['rows']) > 0) {
			foreach ($responseArray['rows'] as $row)
				foreach($row['elements'] as $element) {			
					$response[self::FIELD_DISTANCIA_M] += $element['distance']['value'];	
					$response[self::FIELD_TEMPO] = $element['duration']['text'];			
				}
			$response[self::FIELD_ORIGEM] = $responseArray['origin_addresses'];
			$response[self::FIELD_DESTINO] = $responseArray['destination_addresses'];
		}	
		
		$response[self::FIELD_DISTANCIA_KM] = $this->toKM($response[self::FIELD_DISTANCIA_M]);
		$response[self::FIELD_DISTANCIA_KM_TEXT] = number_format($response[self::FIELD_DISTANCIA_KM], 0, ',', '.') . ' KM';

		return $response;
	}

	public function toKM($metros)
	{	return (int) ($metros / 1000);
	}

}