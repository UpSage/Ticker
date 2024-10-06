<?php



declare(strict_types=1);

namespace UpSage\Ticker\Controller\Adminhtml\Ticker;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use UpSage\Ticker\Model\TickerFactory;

class Delete extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'UpSage_Ticker::ticker';

    private tickerFactory $objectFactory;

    public function __construct(
        Context $context,
        TickerFactory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('ticker_id', null);

        try {
            $objectInstance = $this->objectFactory->create()->load($id);
            if ($objectInstance->getId()) {
                $objectInstance->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the record.'));
            } else {
                $this->messageManager->addErrorMessage(__('Record does not exist.'));
            }
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*');
    }
}
