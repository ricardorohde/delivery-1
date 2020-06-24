<?php
if(!isset($_SESSION['login'])) {
	die('Você não está logado!');
}
	use Database\MySql;
	use App\Site;
	if(isset($_POST['acao'])) {
		$nome = $_POST['nome'];
		$preco = $_POST['preco'];
		$descricao = $_POST['descricao'];
		$imagem = $_FILES['imagem'];
		$restaurante = $_SESSION['login']['id'];
		if(!empty($nome) && !empty($preco) && !empty($descricao) && !empty($imagem) && !empty($restaurante)) {
			if(Site::imagemValida($imagem)) {
				$imagem = Site::uploadFile($imagem);
				$slug = Site::generateSlug($nome);
				$preco = Site::toDouble($preco);
				$sql = MySql::connect()->prepare("INSERT INTO `tb_admin.pratos` VALUES(null,?,?,?,?,?,?)");
				$sql->execute(array($restaurante, $nome, $imagem, $preco, $descricao, $slug));
				Site::alert('success', 'Prato cadastrado com sucesso');
			} else {
				Site::alert('error','Imagem inválida!');
			}
		} else {
			Site::alert('warning', 'Campos vazios não são permitidos!');
		}
	}
?>
<div class="title">
	<i class="fas fa-hamburger"></i> <span>Cadastrar Prato</span>
</div>
<form enctype="multipart/form-data" class="ajax" method="post">
	<div class="form-group">
		<label>Nome:</label>
		<input type="text" name="nome">
	</div>
	<div class="form-group">
		<label>Preço:</label>
		<input type="text" name="preco">
	</div>
	<div class="form-group">
		<label>Descrição:</label>
		<textarea name="descricao"></textarea>
	</div>
	<div class="form-group">
		<label>Imagem:</label>
		<input type="file" name="imagem">
	</div>
	<div class="form-group">
		<input type="submit" name="acao" value="Cadastrar">
	</div>
</form>
<script type="text/javascript">
	$('input[name=preco]').maskMoney({'prefix':'R$','decimal':',','thousands':'.','affixesStay':'true','allowNegative':'false'});
	// $('input[name=volume]').maskMoney({'suffix':'L','affixesStay':'true', 'allowNegative':'false','decimal':',','thousands':'.'});
</script>