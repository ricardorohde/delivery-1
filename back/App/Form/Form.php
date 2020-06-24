<?php
namespace App\Form;
class Form {
	private $fields;
	public function __construct() {
		$this->fields = array();
	}
	public function field($type,$name, $label="", $placeholder="", $value="") {
		echo '<div class="form-group">';
		if(!empty($label))
			echo '<label>'.$label.'</label>';
		echo '<input type="'.$type.'" name="'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'">';
		$this->fields[] = $name;
		echo '</div>';
	}
	public function textarea($name, $label="", $placeholder="") {
		echo '<div class="form-group">';
		if(!empty($label))
			echo '<label>'.$label.'</label>';
		echo '<textarea name="'.$name.'" placeholder="'.$placeholder.'"></textarea>';
		$this->fields[] = $name;
		echo '</div>';
	}
	public function open($standart = true, $ajax = false, $action="", $additional_params="") {
		$result = '<form method="post" ';
		if($standart == true)
			$result.='class="standart';
		if($ajax == true) {
			if(!strstr($result, 'class'))
				$result.='class="ajax"';
			else
				$result.=' ajax';
		}
		$result.='" ';
		$result.= 'action="'.$action.'" '.$additional_params.'>';
		echo $result;
	}
	public function close() {
		echo '</form>';
	}
	public function validate() {
		foreach ($this->fields as $key => $value) {
			if(empty($_POST[$value]))
				return false;
		}
		return true;
	}
}

?>