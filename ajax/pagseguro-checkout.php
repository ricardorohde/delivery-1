<?php
	include('../config.php');
	use App\Site;
	use Database\MySql;
	if(isset($_SESSION['login'])) {
		$data = array();
		$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';
		$data['email'] = PAGSEGURO_EMAIL;
		$data['token'] = PAGSEGURO_TOKEN;
		$data['reference'] = Site::random_id().'?usuario='.$_SESSION['login']['id'];
		$data['currency'] = PAGSEGURO_CURRENCY;
		$index = 1;
		foreach ($_SESSION['cart'] as $key => $value) {
			$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
			$prato->execute(array($key));
			$prato = $prato->fetch();
			$data['itemId'.$index] = $key;
			$data['itemDescription'.$index] = $prato['nome'];
			$data['itemAmount'.$index] = $prato['preco'];
			$data['itemQuantity'.$index] = $value;
			$index++;
		}
		$data = http_build_query($data);
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		$xml = curl_exec($curl);
		curl_close($curl);
		$xml = simplexml_load_string($xml);
		echo $xml->code;

	} else {
		die('Você não está logado!');
	}
?>