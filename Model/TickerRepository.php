<?php

declare(strict_types=1);

namespace UpSage\Ticker\Model;

use UpSage\Ticker\Api\TickerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use UpSage\Ticker\Api\Data\TickerInterface;
use UpSage\Ticker\Api\Data\TickerSearchResultInterface;
use UpSage\Ticker\Api\Data\TickerSearchResultInterfaceFactory;
use UpSage\Ticker\Model\ResourceModel\Ticker\CollectionFactory as TickerCollectionFactory;

class TickerRepository implements TickerRepositoryInterface
{
    private TickerFactory $tickerFactory;
    private TickerCollectionFactory $tickerCollectionFactory;
    private TickerSearchResultInterfaceFactory $searchResultFactory;
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        TickerFactory $tickerFactory,
        TickerCollectionFactory $tickerCollectionFactory,
        TickerSearchResultInterfaceFactory $tickerSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->tickerFactory = $tickerFactory;
        $this->tickerCollectionFactory = $tickerCollectionFactory;
        $this->searchResultFactory = $tickerSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function getById(int $id): TickerInterface
    {
        $ticker = $this->tickerFactory->create();
        $ticker->getResource()->load($ticker, $id);
        if (!$ticker->getId()) {
            throw new NoSuchEntityException(__('Unable to find Ticker with ID "%1"', $id));
        }
        return $ticker;
    }



    public function save(TickerInterface $ticker): void
{
    // Save Ticker
    $ticker->getResource()->save($ticker);

    // Save Store relation
    $this->saveStoreRelation($ticker);
}

private function saveStoreRelation(TickerInterface $ticker): void
{
    $connection = $this->tickerFactory->create()->getResource()->getConnection();
    $tableName = $this->tickerFactory->create()->getResource()->getTable('upsage_ticker_store');
    
    $connection->delete($tableName, ['ticker_id = ?' => (int)$ticker->getId()]);

    foreach ((array)$ticker->getStoreIds() as $storeId) {
        $connection->insert($tableName, [
            'ticker_id' => (int)$ticker->getId(),
            'store_id' => (int)$storeId
        ]);
    }
}



    public function delete(TickerInterface $ticker): void
    {
        $ticker->getResource()->delete($ticker);
    }

    public function getList(SearchCriteriaInterface $searchCriteria): TickerSearchResultInterface
    {
        $collection = $this->tickerCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    public function getByStoreId(int $storeId): array
    {
        $collection = $this->tickerCollectionFactory->create();
        $collection->addFieldToFilter('store_id', $storeId);
        return $collection->getItems();
    }
}
