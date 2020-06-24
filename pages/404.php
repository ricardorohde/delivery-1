<?php
ob_clean();
	use Core\Hantix;
	Hantix::initialize('Delivery - Página não existe!', '', '', 'estilo/style.css');
?>
<style type="text/css">
	html,body {
		background-color: rgb(250,250,250);
	}
</style>
<div class="erro-404">
	<h2><i class="fas fa-exclamation-triangle"></i> 404</h2>
	<p>Página requisitada não existe!</p>
</div>
<?php
	Hantix::end();
	die();
?>