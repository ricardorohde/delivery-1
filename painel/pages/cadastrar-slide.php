<?php
use Database\MySql;
use App\Site;
?>
<div class="title">
	<i class="fas fa-image"></i> <span>Cadastrar Slide</span>
</div>
<?php
	if(isset($_POST['acao'])) {
		try {
			$imagem = @$_FILES['imagem'];
			$info = $_POST['info'];
			if(empty($info) || empty($imagem))
				throw new Exception('Campos vazios não são permitidos!');
			if(!Site::imagemValida($imagem))
				throw new Exception('Imagem inválida!');
			$imagem = Site::uploadFile($imagem);
			$order_id = MySql::find('tb_site.slides', 'ORDER BY order_id DESC LIMIT 1');
			if(empty($order_id))
				$order_id = 1;
			else
				$order_id = $order_id['order_id'] + 1;
			MySql::insert('tb_site.slides', array($order_id, $imagem, $info));
			Site::alert('success', 'Slide cadastrado com sucesso!');
		} catch(Exception $e) {
			Site::alert('error', $e->getMessage());
		}
	}
?>
<form enctype="multipart/form-data" method="post">
	<div class="form-group">
		<label>HTML:</label>
		<textarea name="info"></textarea>
	</div>
	<div class="form-group">
		<label>Imagem:</label>
		<input type="file" name="imagem">
	</div>
	<div class="form-group">
		<input type="submit" name="acao" value="Cadastrar">
	</div>
</form>