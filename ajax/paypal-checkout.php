<?php
include('../config.php');
use Facade\PayPalFacade;
use Database\MySql;
if(isset($_SESSION['login'])) {
	$paypal = new PayPalFacade(PAYPAL_KEY, PAYPAL_SECRET);
	$paypal->setCurrency(PAYPAL_CURRENCY);
	$paypal->setRedirectUrls(INCLUDE_PATH.'paypal/aceito', INCLUDE_PATH.'paypal/recusado.php');
	foreach ($_SESSION['cart'] as $key => $value) {
		$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
		$prato->execute(array($key));
		$prato = $prato->fetch();
		$paypal->addItem($prato['nome'], $value, $prato['preco'], $prato['id']);
	}
	echo $paypal->proccess(PAYPAL_TITLE);
}

?>