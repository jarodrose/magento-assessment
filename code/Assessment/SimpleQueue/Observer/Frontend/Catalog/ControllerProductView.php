<?php

declare(strict_types=1);

namespace Assessment\SimpleQueue\Observer\Frontend\Catalog;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\MessageQueue\PublisherInterface;

class ControllerProductView implements \Magento\Framework\Event\ObserverInterface
{
    const PRODUCT_TOPIC = 'product.topic';

    /**
     * @var PublisherInterface
     */
    private $publisher;

    public function __construct(PublisherInterface $publisher){

        $this->publisher = $publisher;
    }
    /**
     * Adds the product sku to a queue every time it is viewed
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        /** @var $product ProductInterface */
        $product = $observer->getData('product');
        if($product !== null) {
            $this->publisher->publish(self::PRODUCT_TOPIC , 'Sku ' . $product->getSku() . ' was viewed');
        }
    }
}

