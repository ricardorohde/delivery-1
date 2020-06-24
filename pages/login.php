<?php
if(isset($_SESSION['login'])) {
	die('Você já está logado!');
}
use Database\MySql;
use App\Site;
	if(isset($_POST['acao'])) {
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
		$sql = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE (usuario = ? OR email = ? OR numero = ?) AND senha = ?");
		$sql->execute(array($usuario, $usuario, $usuario, $senha));
		if($sql->rowCount() == 1) {
			$user = $sql->fetch();
			$_SESSION['login']['usuario'] = $user['usuario'];
			$_SESSION['login']['log_id'] = Site::random_id();
			$_SESSION['login']['id'] = $user['id'];
			$_SESSION['login']['senha'] = $user['senha'];
			$_SESSION['login']['email'] = $user['email'];
			$_SESSION['login']['numero'] = $user['numero'];
			$_SESSION['login']['nome'] = $user['nome'];
			$_SESSION['login']['imagem'] = $user['imagem'];
			$_SESSION['login']['cargo'] = $user['cargo'];
			Site::redirect(INCLUDE_PATH);
		} else {
			Site::alert('error', 'Login inválido!');
		}
	}
?>
<section class="login">
	<h2>Fazer Login</h2>
	<form method="post">
		<div class="form-group">
			<label>Usuário:</label>
			<input type="text" name="usuario">
		</div>
		<div class="form-group">
			<label>Senha:</label>
			<input class="left" type="password" name="senha">
			<label class="left"><i class="fas fa-eye"></i></label>
			<div class="clear"></div>
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Login">
		</div>
	</form>
	<p>Ainda não é registrado? <a href="<?php echo INCLUDE_PATH; ?>registrar">Registre-se</a> para fazer pedidos</p>
</section>
<?php
	\Core\Hantix::end();
	die();
?>