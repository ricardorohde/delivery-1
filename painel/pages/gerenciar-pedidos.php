<div class="title">
	<i class="fas fa-address-card"></i> <span>Gerenciar Pedidos</span>
</div>
<div class="box-content">
	<?php
	use Database\MySql;
		$pedidos = MySql::connect()->prepare("SELECT * FROM `tb_admin.pedidos` WHERE restaurante = ?");
		$pedidos->execute(array($_SESSION['login']['id']));
		$pedidos = $pedidos->fetchAll();
		foreach ($pedidos as $key => $value) {
			$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
			$prato->execute(array($value['prato']));
			$prato = $prato->fetch();
			$cliente = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
			$cliente->execute(array($value['usuario']));
			$cliente = $cliente->fetch();
	?>
	<div class="pedido-single w50 left">
		<div class="wrapper">
			<h2><?php echo $prato['nome']; ?></h2>
			<div class="info">
				<p><i class="fas fa-user-tie"></i> Cliente: <?php echo $cliente['nome']; ?></p>
				<p><i class="fas fa-address-card"></i> Endereco: <?php echo $value['endereco']; ?></p>
			</div>
			<div class="btns">
				<a class="atualizar" href="<?php echo INCLUDE_PATH_PAINEL; ?>atualizar-pedido?id=<?php echo $value['id']; ?>"><button>Atualizar</button></a>
			</div>
		</div>
	</div>
<?php } ?>
	<div class="clear"></div>
</div>