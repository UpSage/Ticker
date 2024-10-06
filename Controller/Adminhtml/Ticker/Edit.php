<?php



declare(strict_types=1);

namespace UpSage\Ticker\Controller\Adminhtml\Ticker;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use UpSage\Ticker\Model\TickerFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'UpSage_Ticker::ticker';

    private Registry $registry;
    private PageFactory $resultPageFactory;
    private tickerFactory $objectFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        tickerFactory $objectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('ticker_id');
        $objectInstance = $this->objectFactory->create();

        if ($id) {
            $objectInstance->load($id);
            if (!$objectInstance->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $objectInstance->addData($data);
        }

        $this->registry->register('ticker_id', $id);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('UpSage_Ticker::ticker');
        $resultPage->getConfig()->getTitle()->prepend(__('Ticker Edit'));

        return $resultPage;
    }
}
