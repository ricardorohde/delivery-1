<?php
namespace Email;
require(BASE_DIR.'back/API/phpmailer/PHPMailerAutoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Email {
	private $mailer;
	public function __construct($host = EMAIL_HOST, $username = EMAIL_USER, $pass = EMAIL_PASS, $secure = EMAIL_SECURE, $port = EMAIL_PORT, $nome = EMAIL_AUTHOR, $reply = EMAIL_REPLY) {
		$this->mailer = new \PHPMailer();
	    $this->mailer->isSMTP();                                            // Send using SMTP
	    $this->mailer->Host = $host;                    
	    $this->mailer->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $this->mailer->Username   = $username;                     // SMTP username
	    $this->mailer->Password   = $pass;                               // SMTP password
	    $this->mailer->SMTPSecure = $secure;
	    $this->mailer->Port       = $port;  
	    $this->mailer->CharSet = "UTF-8";                                  // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	 //    $this->mailer->SMTPDebug = \SMTP::DEBUG_SERVER;
		// $this->mailer->SMTPDebug = 2;
	    //Recipients
	    $this->mailer->setFrom($username, $nome);
	    $this->mailer->addReplyTo($reply, 'Matheus Acioli');
	}
	public function addAddress($address) {
		$this->mailer->addAddress($address);
	}
	public function setMessage($title, $message) {
		 $this->mailer->isHTML(true);                                  // Set email format to HTML
	     $this->mailer->Subject = $title;
	     $this->mailer->Body    = $message;
	     $this->mailer->AltBody = strip_tags($message);
	}
	public function send() {
		$this->mailer->send();
	} 
}

?>