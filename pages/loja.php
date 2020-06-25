<?php
use Database\MySql;
use App\Site;
$pratos = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos`");
$pratos->execute();
$pratos = $pratos->fetchAll();

if(isset($_POST['search'])) {
	$search = $_POST['pesquisa'];
	$pratos = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE nome LIKE '%$search%' OR descricao = '%$search%'");
	$pratos->execute();
	$pratos = $pratos->fetchAll();
}

?>
<section class="loja">
	<div class="center">
		<h2><i class="fas fa-search"></i> Buscar</h2>
		<form method="post">
			<div class="form-group">
				<input type="text" name="pesquisa">
			</div>
			<div class="form-group">
				<input type="submit" name="search" value="Buscar">
			</div>
		</form>
	</div>
</section>
<section class="container">
	<div class="center">
		<?php
			foreach ($pratos as $key => $value) {
		?>
		<div class="comida-single">
			<img class="w30 left" src="<?php echo INCLUDE_PATH; ?>uploads/<?php echo $value['imagem']; ?>">
			<div class="info w70 left">
				<h2><?php echo Site::toMoney($value['preco']); ?></h2>
				<h3><?php echo $value['nome']; ?></h3>
				<a href="<?php echo INCLUDE_PATH; ?>loja/<?php echo $value['slug']; ?>"><button>Pedir</button></a>
			</div>
			<div class="clear"></div>
		</div>
	<?php } ?>
	</div>
</section>