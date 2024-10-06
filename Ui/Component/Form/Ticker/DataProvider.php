<?php

declare(strict_types=1);

namespace UpSage\Ticker\Ui\Component\Form\Ticker;

use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Ui\DataProvider\AbstractDataProvider;
use UpSage\Ticker\Model\ResourceModel\Ticker\Collection;

class DataProvider extends AbstractDataProvider
{
    private FilterPool $filterPool;
    private array $loadedData = [];

    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        FilterPool $filterPool,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->filterPool = $filterPool;
    }

    public function getData(): array
    {
        if (!$this->loadedData) {
            $items = $this->collection->getItems();
            foreach ($items as $item) {
                $itemData = $item->getData();
                $itemData['dynamic_rows'] = $item->getDynamicRows();
                $this->loadedData[$item->getId()] = $itemData;
            }
        }
        return $this->loadedData;
    }
}
