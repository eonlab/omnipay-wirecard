<?php

namespace Omnipay\Wirecard\Message\TransactionBuilder;

use Omnipay\Wirecard\Message\AbstractRequest;
use Wirecard\Element\Transaction;
use Wirecard\Element\Amount;

class ReferencedTransactionBuilder implements TransactionBuilderInterface
{
    /**
     * @var AbstractRequest
     */
    private $request;

    /**
     * @param AbstractRequest $request
     */
    public function __construct(AbstractRequest $request, $need_amount = 0)
    {
        $this->request = $request;
        $this->need_amount = $need_amount;
    }

    /**
     * @return Transaction
     */
    public function build()
    {
        $transaction = new Transaction();
        $transaction->id = $this->request->getTransactionId();
        $transaction->guWid = $this->request->getTransactionReference();
        if($this->need_amount == 1){
            $transaction->amount = new Amount($this->request->getAmount());
            $transaction->currency = $this->request->getCurrency();
        }
        return $transaction;
    }
}
