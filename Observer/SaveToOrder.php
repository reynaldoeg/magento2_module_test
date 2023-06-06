<?php

namespace ChupaPrecios\TechnicalTest\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveToOrder implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $quote = $event->getQuote();
        $order = $event->getOrder();
        $order->setData('delivery_note', $quote->getData('delivery_note'));
        $order->setData('phone_type', $quote->getData('phone_type'));
    }
}
