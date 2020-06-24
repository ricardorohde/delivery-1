<?php

namespace Facade;
use Twilio\Rest\Client;
require_once BASE_DIR_API.'twilio/autoload.php';
class Twilio {
	private $sid;
	private $token;
	private $number;
	public function __construct() {
		$this->sid = TWILO_SID;
		$this->token = TWILO_TOKEN;
		$this->number = SMS_NUMBER;
	}
	public function SMS($message, $number) {
			$twilio = new Client($this->sid, $this->token);
			$message = $twilio->messages->create('+55'.$number, ["body" => $message, "from" => $this->number]);

	}
}

?>