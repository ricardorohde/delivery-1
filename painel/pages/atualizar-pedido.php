<?php
	use Database\MySql;
	use App\Site;
	use Email\Email;
	define('STATUS_MAX_NUMBER', 2);
	define('STATUS_MIN_NUMBER', 0);
	
	
	$id = (int)$_GET['id'];
	$pedido = MySql::connect()->prepare("SELECT * FROM `tb_admin.pedidos` WHERE id = ?");
	$pedido->execute(array($id));
	$pedido = $pedido->fetch();

	if(isset($_POST['acao_status'])) {
		try {
			$status = $_POST['status'];
			if(!is_numeric($status) || $status > STATUS_MAX_NUMBER || $status < STATUS_MIN_NUMBER)
				throw new Exception('Valor de status inválido!');
			Site::changeOrderStatus($status, $id);
		} catch(Exception $e) {
			Site::alert('error', $e->getMessage());
		}
	}
	if(isset($_POST['acao_email'])) {
		try {
			$titulo = $_POST['titulo'];
			$mensagem = $_POST['mensagem'];
			if(empty($titulo) || empty($mensagem))
				throw new Exception('Campos vazios não são permitidos!');
			$cliente = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
			$cliente->execute(array($pedido['usuario']));
			$cliente = $cliente->fetch();
			$mensagem = str_replace('[order_username]', $cliente['nome'], $mensagem);
			$email = new Email();
			$email->addAddress($cliente['email']);
			$email->setMessage($titulo, $mensagem);
			$email->send();
			Site::alert('success', 'Email enviado com sucesso!');
		} catch(Exception $e) {
			Site::alert('error', $e->getMessage());
		}
	}
?>
<div class="title">
	<i class="fas fa-address-card"></i> <span>Atualizar Status - <?php echo $pedido['id'] ?></span>
</div>
<form method="post">
	<div class="form-group">
		<label>Mudar Status:</label>
		<select name="status">
			<option value="0">Preparando</option>
			<option value="1">A Caminho</option>
			<option value="2">Entregue</option>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" name="acao_status" value="Mudar">
	</div>
</form>
<div class="title">
	<i class="fas fa-envelope"
	></i> <span>Enviar E-mail</span>
</div>
<form method="post">
	<div class="form-group">
		<label>Título</label>
		<input type="text" name="titulo">
	</div>
	<div class="form-group">
		<label>Mensagem:</label>
		<textarea class="tinymce" name="mensagem"></textarea>
		<label>[order_username] = Nome do Usuário</label>
	</div>
	<div class="form-group">
		<input type="submit" name="acao_email" value="Enviar">
	</div>
</form>
<div class="title">
	<i class="fas fa-phone"
	></i> <span>Enviar SMS</span>
</div>
<form method="post">
	<div class="form-group">
		<label>Mensagem:</label>
		<textarea name="mensagem"></textarea>
	</div>
	<div class="form-group">
		<input type="submit" name="acao" value="Enviar">
	</div>
</form>