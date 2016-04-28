<?php
class MoipRequest {
    
	protected $url;
	
	protected $headers = array();
	
	protected $debug;
	
	public function __construct($token, $key, $isSandbox = false, $debug = true) {
		
		if ($isSandbox === false) {
			$this->url = 'https://api.moip.com.br/assinaturas/v1/';
		} else {
			$this->url = 'https://sandbox.moip.com.br/assinaturas/v1/';
		}
		
		$this->headers = array(
			'Authorization: Basic ' . base64_encode($token . ':' . $key),
			'Content-Type: application/json',
			'Accept: application/json'
		);
		
		$this->debug = $debug;
		
		return $this;
	}
	
	public function get($method = '', $data = array()) {
		return $this->request($method, $data, 'GET');
	}
	
	public function post($method = '', $data = array()) {
		return $this->request($method, $data, 'POST');
	}
	
	public function put($method = '', $data = array()) {
		return $this->request($method, $data, 'PUT');
	}
	
	public function delete($method = '', $data = array()) {
		return $this->request($method, $data, 'DELETE');
	}
	
	protected function request($method, $data, $custom_request) {
		// Inicia cURL
		$ch = curl_init();

		// Seta opçoes e parâmetro
		$options = array(
			CURLOPT_URL => $this->url . $method,
			CURLOPT_CUSTOMREQUEST => $custom_request,
			CURLOPT_HTTPHEADER => $this->headers,
			CURLOPT_HEADER => ($this->debug) ? true : false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => utf8_encode(json_encode($data))
		);
		curl_setopt_array($ch, $options);

		// Executa cURL
		$response = curl_exec($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		// Fecha coneçao cURL
		curl_close($ch);
		
		if ($this->debug) {
            
            if (file_exists(DIR_LOGS . 'moip_assinatura.log')) {
                unlink(DIR_LOGS . 'moip_assinatura.log');
            }
            
			$logs = new Log('moip_assinatura.log');
			
			$message = new MoipResponse($response);
			
			$logs->write(array(
				'url' => $this->url . $method,
				'headers' => $this->headers,
				'header' => $message->headers,
				'body' => json_decode($message->body, true)
			));
			
			$logs->write('======================================================');
		}
		
		if ($status_code == 400) {
			throw new Exception(new MoipResponse($response), 400);
		}elseif ($status_code == 401) {
			throw new Exception('Não autorizado. O token de autenticação não é válido ou ele não está habilitado para o Moip Assinaturas.');
		}elseif ($status_code == 404) {
			throw new Exception('Recurso não encontrado.');
		}
		
		return new MoipResponse($response);
	}
}