<section class="registrar">
	<?php
		use Database\MySql;
		use App\Site;
		if(isset($_POST['acao'])) {
			$usuario = $_POST['usuario'];
			$nome = $_POST['nome'];
			$senha = $_POST['senha'];
			$confirmar_senha = $_POST['confirmar-senha'];
			$email = $_POST['email'];
			$numero = $_POST['numero'];
			$imagem = '';
			try {
				if(empty($usuario) || empty($nome) || empty($senha) || empty($email) || empty($numero))
					throw new Exception('Campos vazios não são permitidos!');
				if($senha != $confirmar_senha)
					throw new Exception('Senhas não correspondem!');
				if(!filter_var($email, FILTER_VALIDATE_EMAIL))
					throw new Exception('Email inválido!');
				$validar_usuario = MySql::select('tb_admin.usuarios', 'WHERE usuario = ?', array($usuario));
				if($validar_usuario->rowCount() >= 1)
					throw new Exception('Usuário já existe!');
				$validar_email = MySql::select('tb_admin.usuarios', 'WHERE email = ?', array($email));
				if($validar_email->rowCount() >= 1)
					throw new Exception("Email já existe!");
				$validar_numero = MySql::select('tb_admin.usuarios', 'WHERE numero = ?', array($numero));
				if($validar_numero->rowCount() >= 1)
					throw new Exception("Número já existe!");
				$sql = MySql::connect()->prepare("INSERT INTO `tb_admin.usuarios` VALUES(null,?,?,?,?,?,?,?)");
				$sql->execute(array($usuario, $senha, $email, $numero, $nome, $imagem, 1));
				Site::redirect(INCLUDE_PATH.'login');
			} catch(Exception $e) {
				Site::alert('error', $e->getMessage());
			}
		}
	?>
	<h2>Registrar-se</h2>
	<form method="post">
		<div class="form-group">
			<label>Usuário:</label>
			<input type="text" name="usuario">
		</div>
		<div class="form-group">
			<label>Nome:</label>
			<input type="text" name="nome">
		</div>
		<div class="form-group">
			<label>Senha:</label>
			<input type="password" name="senha">
		</div>
		<div class="form-group">
			<label>Confirmar Senha:</label>
			<input type="password" name="confirmar-senha">
		</div>
		<div class="form-group">
			<label>E-mail:</label>
			<input type="text" name="email">
		</div>
		<div class="form-group">
			<label>Número de Telefone</label>
			<input type="text" name="numero">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Registrar">
		</div>
	</form>
</section>
<script type="text/javascript">
	$('input[name=numero]').mask('99999999999');
</script>