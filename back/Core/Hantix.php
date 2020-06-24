<?php
namespace Core;
class Hantix {
	public static function initialize($seo_title = DEFAULT_SEO_TITLE, $seo_keywords = "", $seo_description = "", $custom_style = "") {
		echo '<!DOCTYPE html>
				<html>
				<head>
					<title>'.$seo_title.'</title>
					<meta charset="utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<meta name="keywords" content="'.$seo_keywords.'">
					<meta name="description" content="'.$seo_description.'">
					'.STANDART_FONT_LINK.'
					<link rel="stylesheet" type="text/css" href="'.INCLUDE_PATH.'front/fontsawesome/estilo/fontawesome.min.css">
					<link rel="stylesheet" type="text/css" href="'.INCLUDE_PATH.'front/fontsawesome/estilo/all.min.css">
					<link rel="stylesheet" type="text/css" href="'.INCLUDE_PATH.'front/source/css/boot.min.css">
					<link rel="stylesheet" type="text/css" href="'.INCLUDE_PATH.'front/source/css/style.min.css">
					<link rel="stylesheet" type="text/css" href="'.INCLUDE_PATH.$custom_style.'">
				</head>
				<body>';
				self::bootCss();
				self::bootJs();
	}
	public static function end() {
		echo '</body>
		</html>';
	}
	public static function bootCss() {
		echo '<style type="text/css">
					*{
						margin: 0;
						padding: 0;
						box-sizing: border-box;
						font-family: '.STANDART_FONT.';
					}

				</style>';
	}
	public static function bootJs() {
		echo '<script src="'.INCLUDE_PATH.'front/js/jquery.min.js"></script>
			  <script src="'.INCLUDE_PATH.'front/js/jquery.ajaxform.min.js"></script>
			  <script src="'.INCLUDE_PATH.'front/js/jquery.maskMoney.min.js"></script>
			  <script src="'.INCLUDE_PATH.'front/js/jquery.mask.min.js"></script>
			  <script>
			  	var include_path = "'.INCLUDE_PATH.'"
			  </script>
			  <script src="https://cloud.tinymce.com/stable/tinymce.min.js" referrerpolicy="origin"></script>
			  <script>tinymce.init({
			  	selector:".tinymce", 
			  	plugins:"image"
			  });</script>';
	}
}

?>