<?php

declare(strict_types=1);

namespace UpSage\Ticker\Model;

use Magento\Framework\Model\AbstractModel;
use UpSage\Ticker\Api\Data\TickerInterface;
use UpSage\Ticker\Model\ResourceModel\Ticker as TickerResourceModel;

class Ticker extends AbstractModel implements TickerInterface
{
    protected $_eventPrefix = 'upsage_ticker';

    protected function _construct(): void
    {
        $this->_init(TickerResourceModel::class);
    }

    public function getId()
    {
        return $this->getData('ticker_id');
    }

    public function setId($value): void
    {
        $this->setData('ticker_id', $value);
    }

    public function getTitle(): ?string
    {
        return $this->getData('title');
    }

    public function setTitle(string $value): void
    {
        $this->setData('title', $value);
    }

    public function getContent(): ?string
    {
        return $this->getData('content');
    }

    public function setContent(string $value): void
    {
        $this->setData('content', $value);
    }

    public function getPublishDate(): ?string
    {
        return $this->getData('publish_date');
    }

    public function setPublishDate(string $value): void
    {
        $this->setData('publish_date', $value);
    }

    public function getStoreIds(): ?array
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }

    public function setStoreIds(array $value): void
    {
        $this->setData('store_id', $value);
    }

    public function setDynamicRows($value): void
    {
        if (is_array($value)) {
            $this->setData('dynamic_rows', json_encode($value));
        } else {
            $this->setData('dynamic_rows', $value);
        }
    }
    
    public function getDynamicRows(): ?array
    {
        $data = $this->getData('dynamic_rows');
        return $data ? json_decode($data, true) : [];
    }

}
