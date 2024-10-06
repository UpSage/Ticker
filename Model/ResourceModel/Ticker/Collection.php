<?php



declare(strict_types=1);

namespace UpSage\Ticker\Model\ResourceModel\Ticker;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use UpSage\Ticker\Model\Ticker;
use UpSage\Ticker\Model\ResourceModel\Ticker as TickerResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'ticker_id';

    protected function _construct(): void
    {
        $this->_init(Ticker::class, TickerResourceModel::class);
    }
}
