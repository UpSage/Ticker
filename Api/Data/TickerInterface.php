<?php

declare(strict_types=1);

namespace UpSage\Ticker\Api\Data;

interface TickerInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $value
     * @return void
     */
    public function setId($value): void;

    /**
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * @param string $value
     * @return void
     */
    public function setTitle(string $value): void;

    /**
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * @param string $value
     * @return void
     */
    public function setContent(string $value): void;

    /**
     * @return string|null
     */
    public function getPublishDate(): ?string;

    /**
     * @param string $value
     * @return void
     */
    public function setPublishDate(string $value): void;

    /**
 * @return int[]|null
 */
    public function getStoreIds(): ?array;

    /**
 * @param int[] $value
 * @return void
 */
    public function setStoreIds(array $value): void;

    /**
     * @return array|null
     */
    public function getDynamicRows(): ?array;

    /**
     * @param array $value
     * @return void
     */
    public function setDynamicRows(array $value): void;
}
