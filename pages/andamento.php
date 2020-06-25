<section class="andamento">
	<h2>Seus pedidos em andamento</h2>
	<?php
		use Database\MySql;
		use App\Site;
		$pedidos = MySql::connect()->prepare("SELECT * FROM `tb_admin.pedidos` WHERE usuario = ?");
		$pedidos->execute(array($_SESSION['login']['id']));
		$pedidos = $pedidos->fetchAll();
		if(count($pedidos) == 0) {
			Site::alert('warning', 'Você não tem pedidos ativos');
			die();
		}
		if(isset($_GET['confirmar'])) {
			$id = (int)$_GET['confirmar'];
			$prato_id = MySql::connect()->prepare("SELECT * FROM `tb_admin.pedidos` WHERE id = ?");
			$prato_id->execute(array($id));
			$prato_id = $prato_id->fetch()['prato'];
			$sql = MySql::connect()->prepare("DELETE FROM `tb_admin.pedidos` WHERE id = ?");
			$sql->execute(array($id));
			$pedidos = MySql::connect()->prepare("SELECT * FROM `tb_admin.pedidos` WHERE usuario = ?");
			$pedidos->execute(array($_SESSION['login']['id']));
			$pedidos = $pedidos->fetchAll();
			Site::alert('success', 'Obrigado por comprar conosco!');
		}
	?>
	<table>
		<thead>
			<tr>
				<th>Prato</th>
				<th>Restaurante</th>
				<th>Status</th>
				<th>#</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($pedidos as $key => $value) {
				$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
				$prato->execute(array($value['prato']));
				$prato = $prato->fetch();
				$restaurante = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
				$restaurante->execute(array($value['restaurante']));
				$restaurante = $restaurante->fetch();

		?>
			<tr>
				<td><img src="<?php echo INCLUDE_PATH; ?>uploads/<?php echo $prato['imagem'];  ?>"></td>
				<td><?php echo $restaurante['nome']; ?></td>
				<td><?php
					switch ($value['status']) {
						case 0:
							echo 'Preparando';
							break;
						case 1:
							echo 'Enviando';
							break;
						case 2:
							echo 'Entregue';
						default:
							# code...
							break;
					}
				?></td>
				<td><a class="confirmar" href="<?php echo INCLUDE_PATH; ?>andamento?confirmar=<?php echo $value['id']; ?>"><button>Confirmar Entrega</button></a></td>
				<td><a href="<?php echo INCLUDE_PATH; ?>reclamacao?id=<?php echo $value['id']; ?>"><button>Reclamar</button></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</section>