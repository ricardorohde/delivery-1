<section class="reclamacao">
	<?php
	use Database\MySql;
	use App\Site;
	use Email\Email;
		if(isset($_POST['acao'])) {
			$id = (int)$_GET['id'];
			try {
				$mensagem = $_POST['mensagem'];
				if(empty($mensagem))
					throw new Exception('Campos vazios não são permitidos!');
				$pedido = MySql::find('tb_admin.pedidos', 'WHERE id = ?', array($id));
				$restaurante = MySql::find('tb_admin.usuarios', 'WHERE id = ?', array($pedido['restaurante']));
				$cliente = MySql::find('tb_admin.usuarios', 'WHERE id = ?', array($pedido['usuario']));
				$email = new Email();
				$email->addAddress($restaurante['email']);
				$mensagem.='<hr>';
				$mensagem.='Cliente: '.$cliente['nome'].'<br>';
				$mensagem.='E-mail do cliente: '.$cliente['email'].'<br>';
				$email->setMessage('Um cliente lhe fez uma reclamação!', $mensagem);
				$email->send();
				Site::redirect(INCLUDE_PATH);
			} catch(Exception $e) {
				Site::alert('error', $e->getMessage());
			}
		}
	?>
	<h2>Envie uma mensagem ao restaurante</h2>
	<form method="post">
		<div class="form-group">
			<label>Mensagem:</label>
			<textarea class="tinymce" name="mensagem"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Enviar">
		</div>
	</form>
</section>