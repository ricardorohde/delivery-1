<?php
use Database\MySql;
use App\Site;
use Facade\PayPalFacade;
use Email\Email;
use App\Store;
Store::clearCart();
$payment = new PayPalFacade();
$payment = $payment->getPayment($_GET['PayerID'], $_GET['paymentId']);
$payment = json_decode($payment);
// echo '<pre>';
// print_r($payment);
// echo '</pre>';
$status = $payment->state;
$payer = $payment->payer->payer_info;
$invoice_number = $payment->transactions[0]->invoice_number;
$items = $payment->transactions[0]->item_list->items;
$line_1 = $payer->shipping_address->line1;
$cidade = $payer->shipping_address->city;
$cep = $payer->shipping_address->postal_code;
$estado = $payer->shipping_address->state;
$pais = $payer->shipping_address->country_code;
$usuario = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
$usuario->execute(array($_SESSION['login']['id']));
$usuario = $usuario->fetch();
$user = $usuario;
$endereco = "$pais: $cidade - $estado; $cep, $line_1";
if($status == 'approved') {
	foreach ($items as $key => $item) {
		$quantidade = $item->quantity;
		$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
		$prato->execute(array($item->sku));
		$prato = $prato->fetch();
		$restaurante_id = $prato['restaurante'];
		$restaurante_do_pedido = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
		$restaurante_do_pedido->execute(array($restaurante_id));
		$restaurante_do_pedido = $restaurante_do_pedido->fetch();
		$verifica = MySql::find('tb_admin.pedidos', 'WHERE usuario = ? AND prato = ?', array($usuario['id'], $prato['id']));
		if(!empty($verifica))
			die('Você já tem esse pedido em andamento');
		$adicionar_pedido = MySql::connect()->prepare("INSERT INTO `tb_admin.pedidos` VALUES(null,?,?,?,?,?,?)");
		$adicionar_pedido->execute(array($item->sku, $restaurante_id, $usuario['id'], $endereco,$quantidade, 0));
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
if($status == 'approved') {
?>
<div class="paypal-aprovado">
	<h2>Pagamento Aprovado!</h2>
	<p><a href="<?php echo INCLUDE_PATH; ?>andamento">Clique aqui</a> para acompanhar o andamento do seu pedido!</p>
</div>
<?php } else { ?>
<?php } ?>