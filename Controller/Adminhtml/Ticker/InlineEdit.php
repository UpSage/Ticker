<?php



declare(strict_types=1);

namespace UpSage\Ticker\Controller\Adminhtml\Ticker;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use UpSage\Ticker\Api\TickerRepositoryInterface;
use UpSage\Ticker\Model\Ticker;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'UpSage_Ticker::ticker';

    private JsonFactory $jsonFactory;
    private TickerRepositoryInterface $repository;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        TickerRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->repository = $repository;
    }

    public function execute(): Json
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        try {
            foreach (array_keys($postItems) as $tickerId) {
                /** @var Ticker $ticker */
                $ticker = $this->repository->getById($tickerId);
                foreach ($postItems[$tickerId] as $key => $value) {
                    $ticker->setData($key, $value);
                }
                $this->repository->save($ticker);
            }
        } catch (Exception $e) {
            $messages[] = __('There was an error saving the data: ') . $e->getMessage();
            $error = true;
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
