<?php



declare(strict_types=1);

namespace UpSage\Ticker\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TickerSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \UpSage\Ticker\Api\Data\TickerInterface[]
     */
    public function getItems();

    /**
     * @param \UpSage\Ticker\Api\Data\TickerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
