<?php



declare(strict_types=1);

namespace UpSage\Ticker\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use UpSage\Ticker\Api\Data\TickerInterface;
use UpSage\Ticker\Api\Data\TickerSearchResultInterface;

interface TickerRepositoryInterface
{
    /**
     * @param int $id
     * @return \UpSage\Ticker\Api\Data\TickerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id): TickerInterface;

    /**
     * @param \UpSage\Ticker\Api\Data\TickerInterface
     * @return void
     */
    public function save(TickerInterface $Ticker): void;

    /**
     * @param \UpSage\Ticker\Api\Data\TickerInterface
     * @return void
     */
    public function delete(TickerInterface $Ticker): void;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \UpSage\Ticker\Api\Data\TickerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TickerSearchResultInterface;
}
