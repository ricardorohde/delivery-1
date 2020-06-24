<?php
use Database\MySql;
?>
<div class="title">
	<i class="fas fa-user"></i> <span>Cadastrar Usuário</span>
</div>
<form enctype="multipart/form-data" class="ajax" method="post">
	<div class="form-group">
		<label>Usuário:</label>
		<input type="text" name="nome">
	</div>
	<div class="form-group">
		<label>Senha:</label>
		<input type="password" name="senha">
	</div>
	<div class="form-group">
		<label>Email:</label>
		<input type="text" name="email">
	</div>
	<div class="form-group">
		<label>Nome:</label>
		<input type="text" name="nome">
	</div>
	<div class="form-group">
		<label>Número de Telefone:</label>
		<input type="text" name="telefone">
	</div>
	<div class="form-group">
		<label>Tipo:</label>
		<select name="cargo">
			<?php
				$cargos = MySql::connect()->prepare("SELECT * FROM `tb_admin.cargos`");
				$cargos->execute();
				$cargos = $cargos->fetchAll();
				foreach ($cargos as $key => $value) {
			?>
			<option value="<?php echo $value['id']; ?>"><?php echo $value['cargo']; ?></option>
		<?php } ?>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" name="acao" value="Cadastrar">
	</div>
</form>