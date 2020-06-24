<section class="banner">
	<div class="overlay"></div>
	<?php
		$slides = MySql::selectAll('tb_site.slides', 'ORDER BY order_id ASC');
		foreach ($slides as $key => $value) {
	?>
	<div style="background-image: url('uploads/<?php echo $value['imagem']; ?>')" class="banner-single">
		<div class="center">
			<div class="info">
				<!-- <h2>Pedidos online</h2>
				<p>Fazer pedidos online nunca foi tão fácil como agora!</p> -->
				<?php echo $value['info']; ?>
			</div>
		</div>
	</div>
</section>
<section class="descricao">
	<i class="fas fa-utensils"></i>
	<h2>Comidas e bebidas mais gostosas</h2>
	<div class="center">
		<div class="desc-single w33 left">
			<div class="wrapper">
				<i class="fas fa-hamburger"></i>
				<h3>Lanches</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in</p>
			</div>
		</div>
		<div class="desc-single w33 left">
			<div class="wrapper">
				<i class="fas fa-carrot"></i>
				<h3>Legumes</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in</p>
			</div>
		</div>
		<div class="desc-single w33 left">
			<div class="wrapper">
				<i class="fas fa-cocktail"></i>
				<h3>Bebidas</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in</p>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</section>
<section class="equipe">
	<h2>Equipe</h2>
	<div class="clear"></div>
	<div class="membro w33 left">
		<div class="wrapper">
			<div class="avatar" style="background-image: url('uploads/depoimento3.png')"></div>
			<h2>Matheus Acioli</h2>
			<h3>Dono</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
	</div>
	<div class="membro w33 left">
		<div class="wrapper">
			<div class="avatar" style="background-image: url('uploads/depoimento2.png')"></div>
			<h2>Veridiana Cavalcante</h2>
			<h3>Sócia</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
	</div>
	<div class="membro w33 left">
		<div class="wrapper">
			<div class="avatar" style="background-image: url('uploads/depoimento1.png')"></div>
			<h2>Marlene</h2>
			<h3>Cozinheira</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
	</div>
	<div class="clear"></div>
</section>
