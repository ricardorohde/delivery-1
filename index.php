<?php
include('config.php');
use Core\Hantix;
use App\Site;
use App\Store;
Hantix::initialize('Delivery System', '', '', 'estilo/style.css');
if(!isset($_SESSION['cart']))
	$_SESSION['cart'] = array();
?>

<header>
	<div class="center">
		<div class="logo w30 left"><a style="text-decoration: none; color: white;" href="<?php echo INCLUDE_PATH; ?>">Delivery</a></div>
		<nav class="desktop w70 left">
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>loja"><?php echo $STANDART_ICONS['search']; ?> Procurar</a></li>
				<li><a class="pedidos" href="<?php echo INCLUDE_PATH; ?>pedidos">Pedidos(<?php echo @Store::getCartItems(); ?>)</a></li>
				<?php
					if(!isset($_SESSION['login'])) {
				?>
				<li><a href="<?php echo INCLUDE_PATH; ?>login">Login</a></li>
			<?php } elseif($_SESSION['login']['cargo'] >= 2) { ?>
				<li><a href="<?php echo INCLUDE_PATH; ?>painel">Painel</a></li>
			<?php } ?>
			<?php
				if(isset($_SESSION['login'])) {
			?>
				<li><a href="<?php echo INCLUDE_PATH; ?>andamento">Andamento(0)</a></li>
		<?php } ?>
			</ul>
		</nav>
		<nav class="mobile w50 left">
			<i class="fas fa-bars"></i>
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>loja">Procurar</a></li>
				<li><a class="pedidos" href="<?php echo INCLUDE_PATH; ?>pedidos">Pedidos(<?php echo @Store::getCartItems(); ?>)</a></li>
				<?php
					if(!isset($_SESSION['login'])) {
				?>
				<li><a href="<?php echo INCLUDE_PATH; ?>login">Login</a></li>
			<?php } elseif($_SESSION['login']['cargo'] >= 2) { ?>
				<li><a href="<?php echo INCLUDE_PATH; ?>painel">Painel</a></li>
			<?php } ?>
			<?php
				if(isset($_SESSION['login'])) {
			?>
				<li><a href="<?php echo INCLUDE_PATH; ?>andamento">Andamento(0)</a></li>
		<?php } ?>
			</ul>
		</nav>
		<div class="clear"></div>
	</div>
</header>
<?php
	$url = explode('/', @$_GET['url']);
	if(file_exists('pages/'.$url[0].'.php')) {
		if($url[0] == 'loja' && isset($url[1])) {
			include('pages/prato-single.php');
		} else {
			include('pages/'.$url[0].'.php');			
		}
	} elseif(empty($url[0])) {
		include('pages/home.php');
	} elseif($url[0] == 'paypal') {
		if($url[1] == 'aceito') {
			include('pages/paypal-aceito.php');
		} elseif($url[1] == 'recusado') {
			include('pages/paypal-recusado.php');
		} else {
			include('pages/404.php');
		}
	} else {
		include('pages/404.php');
	}
?>
<footer>
	<p>Copyright Todos os direitos reservados</p>
</footer>
<script type="text/javascript">
	$('nav.mobile i').click(function() {
		$('nav.mobile ul').slideToggle();
	})
</script>
<?php
Hantix::end();
?>