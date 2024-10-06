<?php

declare(strict_types=1);

namespace UpSage\Ticker\Model\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\StoreManagerInterface;

class StoreOptions implements ArrayInterface
{
    private StoreManagerInterface $storeManager;

    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->storeManager->getStores() as $store) {
            $options[] = [
                'value' => $store->getId(),
                'label' => $store->getName(),
            ];
        }
        return $options;
    }
}
