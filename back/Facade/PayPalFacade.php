<?php
namespace Facade;
require(BASE_DIR.'back/API/paypal/vendor/autoload.php');
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
class PayPalFacade {
	private $apiContext;
	private $payer;
	private $itemList;
	private $amount;
	private $payment;
	private $transaction;
	private $redirect_urls;
	private $itens;
	private $currency;
	public function __construct($app_key = PAYPAL_KEY, $secret = PAYPAL_SECRET) {
		$this->apiContext = new ApiContext(new OAuthTokenCredential($app_key, $secret));
		$this->payer = new Payer();
		$this->payer->setPaymentMethod('paypal');
		$this->itemList = new ItemList();
		$this->amount = new Amount();
		$this->payment = new Payment();
		$this->transaction = new Transaction();
		$this->redirect_urls = new RedirectUrls();
		$this->itens = array();
		$this->currency = 'BRL';
	}
	public function setCurrency($currency) {
		$this->currency = $currency;
	}
	public function addItem($nome, $quantidade, $preco, $id) {
		$item = new Item();
		$item->setName($nome);
		$item->setQuantity($quantidade);
		$item->setPrice($preco);
		$item->setSku($id);
		$item->setCurrency($this->currency);
		$this->itens[] = $item;
	}

	public function setRedirectUrls($sucesso, $cancelar) {
		$this->redirect_urls->setReturnUrl($sucesso);
		$this->redirect_urls->setCancelUrl($cancelar);
	}
	public function proccess($descricao) {
		$this->itemList->setItems($this->itens);
		$preco_total = 0;
		foreach ($this->itens as $key => $value) {
			$preco_total += $value->getPrice() * $value->getQuantity();
		}
		$this->amount->setCurrency($this->currency);
		$this->amount->setTotal($preco_total);
		$this->transaction->setAmount($this->amount);
		$this->transaction->setItemList($this->itemList);
		$this->transaction->setDescription($descricao);
		$this->transaction->setInvoiceNumber(time());
		$this->payment->setRedirectUrls($this->redirect_urls);
		$this->payment->setPayer($this->payer);
		$this->payment->setIntent('sale');
		$this->payment->setTransactions(array($this->transaction));
		$this->payment->create($this->apiContext);
		$approvalLink = $this->payment->getApprovalLink();
		return $approvalLink;
	}

	public function getPayment($payer_id, $payment_id) {
		$payment = \PayPal\Api\Payment::get($payment_id, $this->apiContext);
		$execution = new \PayPal\Api\PaymentExecution();
		$execution->setPayerId($payer_id);
		$result = $payment->execute($execution, $this->apiContext);
		$payment = \PayPal\Api\Payment::get($payment_id, $this->apiContext);
		$payment = Payment::get($payment->getId(), $this->apiContext);
		return $payment;
	}

}

?>