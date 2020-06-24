<?php
	include('../config.php');
	header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
	use Database\MySql;
	use Email\Email;
	$notificationCode = $_GET['notificationCode'];
	$notificationType = $_GET['notificationType'];
	$email = PAGSEGURO_EMAIL;
	$token = PAGSEGURO_TOKEN;
	if(!empty($notificationCode)){
		$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/'.$notificationCode.'?email='.$email.'&token='.$token;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		$xml = curl_exec($curl);
		curl_close($curl);
		$xml = simplexml_load_string($xml);
		$usuario = explode('?usuario=', $xml->reference)[1];
		$user = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
		$user->execute(array($usuario));
		$user = $user->fetch();
		$status = $xml->status;
		$items = $xml->items->item;
		$rua = $xml->shipping->address->street;
		$numero = $xml->shipping->address->number;
		$complemento = $xml->shipping->address->complement;
		$cidade = $xml->shipping->address->city;
		$cep = $xml->shipping->address->postalcode;
		$estado = $xml->shipping->address->state;
		$endereco = "$cidade - $estado; $cep, $rua, $numero, $complemento";
		if($status == 3) {
			foreach ($items as $key => $item) {
				$quantidade = $item->quantity;
				$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
				$prato->execute(array($item->id));
				$restaurante_id = $prato->fetch()['restaurante'];
				$restaurante_do_pedido = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
				$restaurante_do_pedido->execute(array($restaurante_id));
				$restaurante_do_pedido = $restaurante_do_pedido->fetch();
				$adicionar_pedido = MySql::connect()->prepare("INSERT INTO `tb_admin.pedidos` VALUES(null,?,?,?,?,?)");
				$adicionar_pedido->execute(array($item->id, $restaurante_id, $usuario, $endereco, 0));
				$email_para_usuario = new Email();
				$email_para_usuario->addAddress($user['email']);
				$mensagem = "<h2>Olá Sr(a). ".$user['nome']."! Somos da equipe Delivery System</h2>\n";
				$mensagem.="<h3>Seu pedido foi aprovado e está sendo preparado</h3>\n";
				$mensagem.="Informações sobre seu pedido:";
				$mensagem.="<p>Restaurante: ".$restaurante_do_pedido['nome']."</p>";
				$mensagem.="<p>Preço: ".Site::toMoney($prato['preco'] * $quantidade)."</p>";
				$mensagem.="<p>Prato: ".$prato['nome']."</p>";
				$mensagem.="<h2>Você será atualizado por email quanto ao status deste pedido, por isso fique atento!</h2>";
				$email_para_usuario->setMessage('Seu pedido foi aprovado e está sendo preparado!', $mensagem);
				$email_para_usuario->send();
				$email_para_restaurante = new Email();
				$email_para_restaurante->addAddress($restaurante_do_pedido['email']);
				$mensagem = "Olá ".$restaurante_do_pedido['nome']."! Você tem um novo pedido para ser preparado, verifique seu painel!\n";
				$mensagem.='<a href="'.INCLUDE_PATH.'">Clique aqui</a>';
				$email_para_restaurante->setMessage('Você tem um novo pedido para ser preparado!', $mensagem);
				$email_para_restaurante->send();
			}
		}
	}
	//L3fYjKc5n6Rv1kJ9
?>
