<?php
	namespace App;

	class Store {
		public static function addCart($item_id) {
			if(!isset($_SESSION['cart']))
				$_SESSION['cart'] = array();
			if(isset($_SESSION['cart'][$item_id])) {
				$_SESSION['cart'][$item_id]++;
			} else {
				$_SESSION['cart'][$item_id] = 1;
			}
		}
		public static function removeFromCart($item_id) {
			unset($_SESSION['cart'][$item_id]);
		}
		public static function clearCart() {
			unset($_SESSION['cart']);
			$_SESSION['cart'] = array();
		}
		public static function getCartItems() {
			$total = 0;
			foreach ($_SESSION['cart'] as $key => $value) {
				$total+= $value;
			}
			return $total;
		}

	}
?>