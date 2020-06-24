<section class="container">
	<div class="center">
		<?php
			use App\Site;
			use App\Store;
			use Database\MySql;
			if(isset($_GET['clear'])) {
				Store::clearCart();
			}
			foreach ($_SESSION['cart'] as $key => $value) {
				$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
				$prato->execute(array($key));
				$prato = $prato->fetch();
		?>
		<div class="comida-single">
			<img class="w30 left" src="<?php echo INCLUDE_PATH; ?>uploads/<?php echo $prato['imagem']; ?>">
			<div class="info w70 left">
				<h2><?php echo Site::toMoney($prato['preco']); ?></h2>
				<h3><?php echo $prato['nome']; ?></h3>
				<p style="font-weight: bold; font-size: 25px;"><?php echo $value; ?></p>
			</div>
			<div class="clear"></div>
		</div>
	<?php } ?>
	</div>
</section>
<section class="fechar">
	<div class="center">
		<?php
		$total = 0;
			foreach ($_SESSION['cart'] as $key => $value) {
				$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE id = ?");
				$prato->execute(array($key));
				$prato = $prato->fetch();
				$total+= $prato['preco'] * $value;
			}
		?>
		<h2><?php echo Site::toMoney($total); ?></h2>
		<a class="clear" href="<?php echo INCLUDE_PATH; ?>pedidos?clear"><button>Limpar Carrinho</button></a>
		<div class="payment-buttons">
			<h2>Pagar com:</h2>
			<a class="fechar-pagseguro left" href=""><button>Pagseguro</button></a>
			<a class="fechar-paypal left" href=""><button><i class="fab fa-paypal"></i> PayPal</button></a>
			<div class="clear"></div>
		</div>
	</div>
</section>
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<script type="text/javascript">
	$('a.fechar-pagseguro').click(function(e) {
		e.preventDefault();
		$.ajax({
			url:include_path+'ajax/pagseguro-checkout.php',
			method:'post',
			beforeSend:function() {
				$('html,body').animate({'opacity':'0.6'},500);
				$('a').attr('disabled','true');
			}
		}).done(function(data) {
			$('html,body').animate({'opacity':'1'},500);
			$('a').removeAttr('disabled');
			if(data=='Você não está logado!') {
				alert('Você não está logado!');
			} else {
				var isOpenLB = new PagSeguroLightbox({
					code: data
				},{
					success: function() {

					},
					abort: function() {

					}
				})
			}
		})
	});
	$('a.fechar-paypal').click(function(e) {
		e.preventDefault();
		$.ajax({
			url:include_path+'ajax/paypal-checkout.php',
			method:'post',
			beforeSend:function(){
				$('html,body').animate({'opacity':'0.6'},500);
				$('a').attr('disabled','true');
			}
		}).done(function(data) {
			// $('html,body').animate({'opacity':'1'},500);
			// $('a').removeAttr('disabled');
			location.href=data;
		})
	})
</script>