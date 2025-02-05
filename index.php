<?php
/**
 * @param $url
 * @param $data
 * @param $headers
 * @param $limit
 * @return string|void
 */
function sendLead($url,$data,$headers = [],$limit = 30){
	$timeout = $limit<30?30:$limit*0.8;
	$headersDefault = [
		"Content-type"=>"application/x-www-form-urlencoded",
		"Connection"=>"close"
	];
    $headersString = '';
    if(!empty($headers))
    	foreach ($headers as $key => $value)
    		$headersDefault[$key] = $value;
	foreach ($headersDefault as $key => $value)
		$headersString .= sprintf("%s: %s\r\n",$key,$value);

	if($headersDefault["Content-type"]=="application/x-www-form-urlencoded"){
		$data = http_build_query($data);
	}
	if($headersDefault["Content-type"]=="application/json"){
		$data = json_encode($data);
	}

    $data_len = strlen($data);
	$headersString .= sprintf('Content-Length: %s',$data_len)."\r\n";

	$ctx = stream_context_create(array('http' =>
		array(
			'timeout' => $timeout,
			'method' => 'POST',
			'header' => $headersString,
			//'protocol_version'=>'1.1',
			'content' => $data
		)
	));

	$result = @file_get_contents($url,0,$ctx);
	if ($result === FALSE) {
		echo sprintf("Can's send lead (%s) at url %s",$data,$url).PHP_EOL;
		var_dump($result);
	}else{
		return $result;
	}
}

$token = 'your_token';
$endpointUrl = 'your_endpoint_url';
$data = [
    "reference" => 'AP0085_BEN',
    "name" => 'nome do lead',
    "email" => 'email@example.com',
    "phone" => '552799999999',
    "message" => 'esta é a mensagem do lead'
];

$header = ["Content-type"=>"application/json", "Authorization" => "Basic ".$token];
$result = sendLead($endpointUrl, $data, $header);

var_dump($result);
