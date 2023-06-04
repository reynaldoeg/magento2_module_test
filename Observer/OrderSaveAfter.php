<?php

namespace ChupaPrecios\TechnicalTest\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderSaveAfter implements ObserverInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $this->_logger->info('Observer: New Order');

        $order = $observer->getEvent()->getOrder();

        $response = [
            'order_id' => $order->getIncrementId(),
            'created_at' => $order->getCreatedAt(),
            'customer_id' => $order->getCustomerId(),
            'customer_firstname' => $order->getCustomerFirstname(),
            'customer_lastname' => $order->getCustomerLastname(),
            'customer_email' => $order->getCustomerEmail(),
            'subtotal' => $order->getSubtotal(),
            'shipping' => $order->getShippingAmount(),  // X
            'total' => $order->getGrandTotal(),
        ];

        $items = [];
        foreach ($order->getAllItems() as $item) {
            $items[] = [
                'product_id' => $item->getProductId(),
                'name' => $item->getName(),
                'sku' => $item->getSku(),
                'qty_ordered' => $item->getQtyOrdered(),
                'price' => $item->getPrice(),
                'original_price' => $item->getOriginalPrice(),
            ];
        }

        $response['items'] = $items;

        $this->_logger->info(json_encode($response));
    }
}
