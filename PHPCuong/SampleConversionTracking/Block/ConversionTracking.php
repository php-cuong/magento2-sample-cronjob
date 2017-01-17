<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2017-01-17 09:10:33
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-01-17 10:28:41
 */

namespace PHPCuong\SampleConversionTracking\Block;

class ConversionTracking extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var int
     */
    protected $oderId;

    /**
     * @var array
     */
    protected $lastOrder;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
    }

    protected function _prepareLayout()
    {
        $lastOrder = $this->checkoutSession->getLastRealOrder();
        $this->orderId = $lastOrder->getIncrementId();
        $this->lastOrder = $lastOrder->getData();
        return parent::_prepareLayout();
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getLastOrder()
    {
        return $this->lastOrder;
    }
}
