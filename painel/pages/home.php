<?php
use Core\Hantix;
use Database\MySql;
use App\Site;
?>
<div class="title">
	<i class="fas fa-home"></i> <span>Home</span>
</div>
<div class="box-single">
	<h2>Usuários</h2>
	<table>
		<thead>
			<tr>
				<th>Nome</th>
				<th>Email</th>
				<th>Usuário</th>
				<th>Cargo</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$usuarios = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` ORDER BY cargo DESC LIMIT 50");
				$usuarios->execute();
				$usuarios = $usuarios->fetchAll();
				foreach ($usuarios as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['nome']; ?></td>
				<td><?php echo $value['email']; ?></td>
				<td><?php echo $value['usuario']; ?></td>
				<td><?php echo Site::getCargo($value['cargo']); ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>