<?php
// include('../../config.php');
namespace App;
use Database\MySql;
use Email\Email;
class Site {
	public static function random_id() {
		return md5(uniqid().uniqid().uniqid().uniqid());
	}
	public static function logout($redirect="") {
		unset($_SESSION['login']);
		if(!empty($redirect))
			self::redirect($redirect);

	}
	public static function generateSlug($str) {
		$str = mb_strtolower($str);
		$str = preg_replace('/(à|á|â|ã)/', 'a', $str);
		$str = preg_replace('/(é|è|ê)/', 'e', $str);
		$str = preg_replace('/(í|ì|î)/', 'i', $str);
		$str = preg_replace('/(ó|ô|ò|õ)/', 'o', $str);
		$str = preg_replace('/(ú|ù|û)/', 'u', $str);
		$str = preg_replace('/( )+/', '-', $str);
		$str = preg_replace('/(ç)/', 'c', $str);
		$str = preg_replace('/(\?|\"|\'|\*|#|@|!|\.|;)+/', '', $str);
		return $str;
	}
	public static function toDouble($str) {
		$str = str_replace('R$', '', $str);
		$str = str_replace(',', '.', $str);
		$str = number_format($str, 2, '.','');
		return $str;
	}
	public static function toMoney($str) {
		$str = number_format($str, 2, ',','.');
		$str = substr_replace($str, 'R$', 0,0);
		return $str;
	}
	public static function redirect($link) {
		echo '<script>location.href="'.$link.'"</script>';
	}
	public static function alert($status, $mensagem) {
		switch ($status) {
			case 'success':
				echo '<div class="alert success"><i class="fas fa-check"></i> '.$mensagem.'</div>';
				break;
			case 'error':
				echo '<div class="alert error"><i class="fas fa-times"></i> '.$mensagem.'</div>';
				break;
			case 'warning':
				echo '<div class="alert warning"><i class="fas fa-exclamation-triangle"></i> '.$mensagem.'</div>';
				break;
			
			default:
				# code...
				break;
		}
	}
	public static function uploadFile($file) {
		$extension = explode('.', $file['name'])[1];
		$nome = Site::random_id();
		$nome.='.'.$extension;
		move_uploaded_file($file['tmp_name'], BASE_DIR.'uploads/'.$nome);
		return $nome;

	}
	public static function imagemValida($imagem) {
		if($imagem['type'] == 'image/jpg' || $imagem['type'] == 'image/png' || $imagem['type'] == 'image/jpeg') {
			return true;
		}
		return false;
	}

	//Your App

	public static function hasPermission($cargo) {
		if($_SESSION['login']['cargo'] >= $cargo)
			return true;
		return false;
	}

	public static function getCargo($cargo) {
		$sql = MySql::connect()->prepare("SELECT * FROM `tb_admin.cargos` WHERE id = ?");
		$sql->execute(array($cargo));
		return $sql->fetch()['cargo'];
	}
	public static function changeOrderStatus($status,$pedido_id) {
		$cliente = MySql::connect()->prepare("SELECT * FROM `tb_admin.pedidos` WHERE id = ?");
		$cliente->execute(array($pedido_id));
		$cliente_id = $cliente->fetch()['usuario'];
		$cliente = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
		$cliente->execute(array($cliente_id));
		$cliente = $cliente->fetch();
		switch ($status) {
			case 0: //0 = Preparando
				$sql = MySql::connect()->prepare("UPDATE `tb_admin.pedidos` SET status = ? WHERE id = ?");
				$sql->execute(array($status, $pedido_id));
				$email = new Email();
				$email->addAddress($cliente['email']);
				$message = "<h2>Seu pedido está sendo preparado!</h2>";
				$message.="<p>O restaurante já está preparando o seu pedido e em breve ele chegará! Fique atento a portaria e acompanhe seu pedido <a href=".INCLUDE_PATH."pedidos>Clicando aqui</a></p>";
				$email->setMessage("Seu pedido está a caminho!", $message);
				$email->send();
				Site::alert('success', 'Status atualizado com sucesso!');
				break;
			case 1: //1 = A Caminho
				$sql = MySql::connect()->prepare("UPDATE `tb_admin.pedidos` SET status = ? WHERE id = ?");
				$sql->execute(array($status, $pedido_id));
				$email = new Email();
				$email->addAddress($cliente['email']);
				$message = "<h2>Seu pedido está a caminho!</h2>";
				$message.="<p>O restaurante já está preparando o seu pedido e em breve ele chegará! Fique atento a portaria e acompanhe seu pedido <a href=".INCLUDE_PATH."pedidos>Clicando aqui</a></p>";
				$email->setMessage("Seu pedido está a caminho!", $message);
				$email->send();
				Site::alert('success', 'Status atualizado com sucesso!');
				break;
			case 2: //2 = Entregue
				$sql = MySql::connect()->prepare("UPDATE `tb_admin.pedidos` SET status = ? WHERE id = ?");
				$sql->execute(array($status, $pedido_id));
				$email = new Email();
				$email->addAddress($cliente['email']);
				$message = "<h2>Seu pedido foi entregue!</h2>";
				$message.="<p>Caso queira fazer alguma reclamação ou queira avaliar o lanche, <a href=".INCLUDE_PATH."pedidos>Clique Aqui</a></p>";
				$email->setMessage("Seu pedido foi entregue!", $message);
				$email->send();
				Site::alert('success', 'Status atualizado com sucesso!');
				break;
			default:
				break;
		}
	}
}

?>