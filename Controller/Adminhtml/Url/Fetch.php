<?php

namespace UpSage\Ticker\Controller\Adminhtml\Url;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class Fetch extends \Magento\Backend\App\Action
{
    protected $resultJsonFactory;
    protected $productCollectionFactory;
    protected $pageCollectionFactory;
    protected $categoryCollectionFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ProductCollectionFactory $productCollectionFactory,
        PageCollectionFactory $pageCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function execute()
    {
        $type = $this->getRequest()->getParam('type');
        $urls = [];

        switch ($type) {
            case 'cms_page':
                $pages = $this->pageCollectionFactory->create()->addFieldToSelect('identifier');
                foreach ($pages as $page) {
                    $urls[] = $page->getIdentifier();
                }
                break;

            case 'product':
                $products = $this->productCollectionFactory->create()->addAttributeToSelect('url_key');
                foreach ($products as $product) {
                    $urls[] = $product->getUrlKey();
                }
                break;

            case 'category':
                $categories = $this->categoryCollectionFactory->create()->addAttributeToSelect('url_key');
                foreach ($categories as $category) {
                    $urls[] = $category->getUrlKey();
                }
                break;
        }

        $result = $this->resultJsonFactory->create();
        return $result->setData(['urls' => $urls]);
    }
}
