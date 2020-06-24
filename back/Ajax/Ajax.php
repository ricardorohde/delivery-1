<?php
namespace Ajax;
class Ajax {
	public static function call($selector,$url, $additional_data, $action="") {
		echo "<script>
				$('{$selector}').click(function(e) {
					e.preventDefault();
					$(this).ajaxForm({
						method:'post',
						dataType:'json',
						data:'{$additional_data}',
						url: '{$url}',
						success: function(data) {
							$('html,body').animate({opacity:1}, 500);
							$(this).find([type=submit]).removeAttr('disabled');
							$action;
						},
						beforeSend: function() {
							$('html,body').animate({opacity:0.6}, 500);
							$(this).find([type=submit]).attr('disabled','true');
						}
					});
				});
			  </script>";
	}
}
?>