<?php

namespace Omnipay\Wirecard\Message\TransactionBuilder;

use Omnipay\Common\CreditCard;
use Wirecard\Element\Amount;
use Wirecard\Element\CreditCardData;
use Wirecard\Element\Secure;
use Wirecard\Element\Transaction;
use Wirecard\Element\RecurringTransaction;

class PaymentTransactionBuilder extends EnrollmentTransactionBuilder
{
    public function build()
    {
        if ($this->request->getTransactionReference()) {
            $transaction = new Transaction();
            $transaction->id = $this->request->getTransactionId();
            $transaction->guWid = $this->request->getTransactionReference();
            $transaction->creditCardData = new CreditCardData();
            $transaction->amount = new Amount($this->request->getAmount());
            $transaction->currency = $this->request->getCurrency();
            $transaction->recurringTransaction = new RecurringTransaction('Repeated');

            if ($this->request->getToken()) {
                $transaction->secure = Secure::createResponse($this->request->getToken());
            }
        } else {
            $transaction = parent::build();
            /** @var CreditCard $creditCard */
            $creditCard = $this->request->getCard();
            $transaction->creditCardData->secureCode = $creditCard->getCvv();
        }

        return $transaction;
    }
}
