<?php
use Database\MySql;
use App\Site;
$prato = MySql::connect()->prepare("SELECT * FROM `tb_admin.pratos` WHERE slug = ?");
$prato->execute(array($url[1]));
if($prato->rowCount() == 0) {
	Site::alert('error', 'Prato inválido!');
	die();
}
$prato = $prato->fetch();
$restaurante = MySql::connect()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE id = ?");
$restaurante->execute(array($prato['restaurante']));
$restaurante = $restaurante->fetch();
?>
<section class="prato">
	<div class="center">
		<h2><?php echo $prato['nome']; ?></h2>
		<p>por: <?php echo $restaurante['nome']; ?></p>
		<img src="<?php echo INCLUDE_PATH ?>uploads/<?php echo $prato['imagem']; ?>">
		<h3>Sobre:</h3>
		<p><?php echo $prato['descricao']; ?></p>
		<div class="comprar">
			<h4><?php echo Site::toMoney($prato['preco']); ?></h4>
			<a ref="<?php echo $prato['id']; ?>" class="carrinho" href=""><button><?php echo $STANDART_ICONS['cart']; ?> Adicionar ao Carrinho</button></a>
		</div>
	</div>
</section>
<script type="text/javascript">
	$('a.carrinho').click(function(e) {
		e.preventDefault();
		$.ajax({
			url:include_path+'ajax/adicionar-carrinho.php',
			method:'post',
			dataType: 'json',
			data:{'item_id':$(this).attr('ref')},
			// dataType:'json',
			beforeSend: function() {
				$('html,body').animate({'opacity':'0.6'},500);
			}
		}).done(function(data) {
			$('html,body').animate({'opacity':'1'},500);
			if(data['status'] == 'true') {
				$('a.pedidos').html('Pedidos('+data['mensagem']+')');
				// alert('oi');
			} else {
				$('section.prato .center').prepend(data);
				var scrollTop = $('html,body').scrollTop();
				$('html,body').animate({scrollTop : '0'}, 200);
			}
		})
	})
</script>
