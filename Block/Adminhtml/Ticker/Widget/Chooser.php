<?php

namespace UpSage\Ticker\Block\Adminhtml\Ticker\Widget;

class Chooser extends \Magento\Backend\Block\Widget\Grid\Extended
{

    protected $_collectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \UpSage\Ticker\Model\TickerFactory $tickerFactory,
        \UpSage\Ticker\Model\ResourceModel\Ticker\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_tickerFactory = $tickerFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setDefaultSort('ticker_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
    }

    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());
        $sourceUrl = $this->getUrl('upsage_ticker/ticker_widget/chooser', ['uniq_id' => $uniqId]);

        $chooser = $this->getLayout()->createBlock(
            \Magento\Widget\Block\Adminhtml\Widget\Chooser::class
        )->setElement(
            $element
        )->setConfig(
            $this->getConfig()
        )->setFieldsetId(
            $this->getFieldsetId()
        )->setSourceUrl(
            $sourceUrl
        )->setUniqId(
            $uniqId
        );

        if ($element->getValue()) {
            $ticker = $this->_tickerFactory->create()->load($element->getValue());
            if ($ticker->getId()) {
                $chooser->setLabel($this->escapeHtml($ticker->getTitle()));
            } else {
                $chooser->setLabel(__('No Ticker Found'));
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;

    }

    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");  
                var tickerId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var tickerTitle = trElement.down("td").next().innerHTML;
                ' .
            $chooserJsObject .
            '.setElementValue(tickerId);
                ' .
            $chooserJsObject .
            '.setElementLabel(tickerTitle);
                ' .
            $chooserJsObject .
            '.close();
            }
        ';
        return $js;
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_collectionFactory->create());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn(
            'chooser_id',
            ['header' => __('ID'), 'align' => 'right', 'index' => 'ticker_id', 'width' => 50]
        );

        $this->addColumn(
            'chooser_title',
            ['header' => __('Title'), 'align' => 'left', 'index' => 'title']
        );

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('upsage_ticker/ticker_widget/chooser', ['_current' => true]);
    }

}
