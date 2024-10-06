<?php

namespace UpSage\Ticker\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Ticker extends Template implements BlockInterface
{
    protected $_template = 'UpSage_Ticker::widget/ticker.phtml';

    protected $_tickerFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \UpSage\Ticker\Model\TickerFactory $tickerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_tickerFactory = $tickerFactory;
    }

    public function getTickerData()
    {
        $tickerId = $this->getData('ticker_id');
        if ($tickerId) {
            $ticker = $this->_tickerFactory->create()->load($tickerId);
            return $ticker->getData();
        }
        return null;
    }
}
