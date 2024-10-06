<?php

declare(strict_types=1);

namespace UpSage\Ticker\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DB\Adapter\AdapterInterface;

class Ticker extends AbstractDb
{
    protected function _construct(): void
    {
        // Initialize the main table 'upsage_ticker' and primary key 'ticker_id'
        $this->_init('upsage_ticker', 'ticker_id');
    }

    /**
     * Override the save method to include store data.
     */
    public function save(AbstractModel $object): self
    {
        // First, save to the main table (upsage_ticker)
        parent::save($object);
        
        // Now, save to the secondary table (upsage_ticker_store)
        $this->saveStoreData($object);
        
        return $this;
    }

    /**
     * Save store data to the upsage_ticker_store table.
     */
    protected function saveStoreData(AbstractModel $object): void
    {
        $connection = $this->getConnection();
        $tickerId = $object->getId();  // Get the saved ticker ID
        $storeIds = (array) $object->getStoreIds();  // Assuming the model has a method getStoreIds()

        // First, delete existing store records for this ticker ID
        $connection->delete(
            $this->getTable('upsage_ticker_store'),
            ['ticker_id = ?' => $tickerId]
        );

        // Now, insert the new store IDs
        foreach ($storeIds as $storeId) {
            $connection->insert(
                $this->getTable('upsage_ticker_store'),
                ['ticker_id' => $tickerId, 'store_id' => $storeId]
            );
        }
    }
}
