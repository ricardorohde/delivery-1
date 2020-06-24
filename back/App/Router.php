<?php
namespace App;
class Router {
	public static function get($url, $pagina) {
		// contato/supervisao
		$urlPar = @$_GET['url'];
		if($url == $urlPar) {
			if(file_exists(BASE_DIR.'public/pages/'.$pagina)){
				include(BASE_DIR.'public/pages/'.$pagina);
			} else {
				die('Página não existe');
			}
		}
	}
}

?>