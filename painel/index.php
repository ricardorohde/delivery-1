<?php
	use App\Site;
	include('../config.php');
	if(isset($_SESSION['login'])) {
		include('main.php');
	} else {
		Site::redirect(INCLUDE_PATH);
	}
?>