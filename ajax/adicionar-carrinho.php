<?php
	include('../config.php');
	// use Database\MySql;
	use App\Store;
	use App\Site;

	if(isset($_POST['item_id']) && isset($_SESSION['login'])) {
		Store::addCart($_POST['item_id']);
		sleep(1);
		die(json_encode(array('status'=>'true', 'mensagem'=>Store::getCartItems())));
	} else {
		Site::alert('error', 'Você precisa estar logado para adicionar um item ao carrinho');
	}
?>