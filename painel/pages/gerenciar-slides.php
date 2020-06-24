<?php
	use Database\MySql;
	use App\Site;

	if(isset($_GET['delete'])) {
		$id = (int)$_GET['delete'];
		$imagem = @MySql::find('tb_site.slides', 'WHERE id = ?', array($id))['imagem'];
		@unlink(BASE_DIR.'uploads/'.$imagem);
		MySql::delete('tb_site.slides', 'WHERE id = ?', array($id));
		Site::alert('success', 'Slide deletado com sucesso!');
	}
	if(isset($_GET['order'])) {
		if($_GET['order'] == 'up') {
			$id = (int)$_GET['id'];
			$order_id = MySql::find('tb_site.slides', 'WHERE id = ?', array($id));
			$target = MySql::find('tb_site.slides', 'WHERE order_id = ?', array($order_id['order_id'] - 1));
			if(empty($target)) {

			} else {
				$aux = $order_id['order_id'];
				MySql::update('tb_site.slides', 'SET order_id = ? WHERE id = ?', array($target['order_id'], $order_id['id']));
				MySql::update('tb_site.slides', 'SET order_id = ? WHERE id = ?', array($aux, $target['id']));
			}
		} elseif($_GET['order'] == 'down') {
			$id = (int)$_GET['id'];
			$order_id = MySql::find('tb_site.slides', 'WHERE id = ?', array($id));
			$target = MySql::find('tb_site.slides', 'WHERE order_id = ?', array($order_id['order_id'] + 1));
			if(empty($target)) {

			} else {
				$aux = $order_id['order_id'];
				MySql::update('tb_site.slides', 'SET order_id = ? WHERE id = ?', array($target['order_id'], $order_id['id']));
				MySql::update('tb_site.slides', 'SET order_id = ? WHERE id = ?', array($aux, $target['id']));
			}
		}
	}
?>
<div class="title">
	<i class="fas fa-image"></i> <span>Gerenciar Slides</span>
</div>
<div class="box-content">
	<table class="slides">
		<thead>
			<tr>
				<th>Slide</th>
				<th>Título</th>
				<th>#</th>
				<th>#</th>
				<th>#</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$slides = MySql::selectAll('tb_site.slides', 'ORDER BY order_id ASC');
				foreach ($slides as $key => $value) {
					$titulo = preg_match_all('/<h2>(.*?)<\/h2>/', $value['info'], $result);
			?>
			<tr>
				<td><img src="<?php echo INCLUDE_PATH.'uploads/'.$value['imagem'] ?>"></td>
				<td><?php echo $result[0][0]; ?></td>
				<td><a class="editar" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-slide?id=<?php echo $value['id']; ?>"><button><i class="fas fa-pencil-alt"></i> Editar</button></a></td>
				<td><a class="deletar" href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-slides?delete=<?php echo $value['id']; ?>"><button><i class="fas fa-trash"></i> Excluir</button></a></td>
				<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>gerenciar-slides?order=up&id=<?php echo $value['id']; ?>"><i class="fas fa-angle-up"></i></a></td>
				<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>gerenciar-slides?order=down&id=<?php echo $value['id']; ?>"><i class="fas fa-angle-down"></i></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>