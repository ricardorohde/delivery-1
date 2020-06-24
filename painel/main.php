<?php
use Core\Hantix;
use Database\MySql;
use App\Site;
	Hantix::initialize('Delivery System - Painel de Controle', '', '', 'painel/estilo/style.css');
	if(isset($_GET['logout'])) {
		Site::logout();
		Site::redirect(INCLUDE_PATH_PAINEL);
		die();
	}
?>
<header>
	<div class="logo w50 left"><a href="<?php echo INCLUDE_PATH_PAINEL; ?>">Painel de Controle</a></div>
	<nav class="painel left w50">
		<ul>
			<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>"><i class="fas fa-home"></i> Home</a></li>
			<li ref="cadastrar" class="dropdown"><a class="menu" href="">Cadastrar <?php echo $STANDART_ICONS['angle-down']; ?></a>
				<ul ref="cadastrar">
					<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-pratos">Pratos</a></li>
					<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-usuario">Usuário</a></li>
					<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-slide">Slide</a></li>
					<!-- <li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>cadastrar-usuarios">Pedidos</a></li> -->
				</ul>
			</li>
			<li ref="gerenciar" class="dropdown"><a class="menu" href="">Gerenciar <?php echo $STANDART_ICONS['angle-down']; ?></a>
				<ul ref="gerenciar">
					<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>gerenciar-pratos">Pratos</a></li>
					<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>gerenciar-pedidos">Pedidos</a></li>
					<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>gerenciar-slides">Slides</a></li>
				</ul>
			</li>
			<li><a href="<?php echo INCLUDE_PATH_PAINEL; ?>?logout"><?php echo $STANDART_ICONS['out'] ?> Logout</a></li>
		</ul>
	</nav>
	<div class="clear"></div>
</header>
<div class="box-content">
	<?php
		$url = explode('/', @$_GET['url'])[0];
		if(@file_exists('pages/'.$url.'.php')) {
			include('pages/'.$url.'.php');
		} elseif(empty($url)) {
			include('pages/home.php');
		} else {
			Site::redirect(INCLUDE_PATH_PAINEL);
		}
	?>
</div>
<script type="text/javascript">
	$('li.dropdown a.menu').click(function(e) {
		e.preventDefault();
		var ref = $(this).parent().attr('ref');
		// $('li.dropdown ul').css({'display':'none'});
		$('li.dropdown ul[ref='+ref+']').slideToggle();
	})
</script>
<?php
Hantix::end();
?>