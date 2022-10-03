<?php
class RestResponse{
	private static $statusCodes = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		509 => 'Bandwidth Limit Exceeded'
	);

	public function __construct(){
		header('Pragma: no-cache');
	}

	public function setContentLength($response){
		header('Content-Length: ' . strlen($response));
	}

	public function setAccessControlOrigin($accessPolicy){
		header('Access-Control-Allow-Origin: ' . $accessPolicy);
	}

	public function setAccessControlMethods($accessPolicy){
		header('Access-Control-Allow-Methods: ' . $accessPolicy);
	}

	public function sendResponse($http_code = '200', $message){
		$status = self::$statusCodes[intval($http_code)];
		header('HTTP/1.0 ' . ($status ? $http_code . ' ' . $status : $http_code), true, $http_code);

		$message = array_reverse($message, true);
		$message['status'] = intval($http_code);
		$message = array_reverse($message, true);

		echo $this->jsonResponse($message);
		exit;
	}

	public function jsonResponse($pMessage){
		header('Content-Type: application/json; charset=UTF-8');

		$result = $this->jsonFormat($pMessage);
		$this->setContentLength($result);

		return $result;
	}

	public function jsonFormat($json){
		return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	}

}