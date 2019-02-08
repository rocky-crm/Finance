<?php

namespace Finance\Service;

use Finance\Storage\MySQL\IncomeMapper;
use Krystal\Application\Model\AbstractService;
use Krystal\Stdlib\VirtualEntity;

final class IncomeService extends AbstractService
{
    /**
     * Income mapper instance
     * 
     * @var \Finance\Storage\MySQL\IncomeMapper
     */
    private $incomeMapper;

    /**
     * State initialization
     * 
     * @param \Finance\Storage\MySQL\IncomeMapper $incomeMapper
     * @return void
     */
    public function __construct(IncomeMapper $incomeMapper)
    {
        $this->incomeMapper = $incomeMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'])
               ->setCurrencyId($row['currency_id'])
               ->setCurrency($row['currency'] ?? null)
               ->setFrom($row['from'])
               ->setDate($row['date'])
               ->setAmount($row['amount'])
               ->setComment($row['comment']);

        return $entity;
    }

    /**
     * Fetches entity by its id
     * 
     * @param int $id
     * @return mixed
     */
    public function fetchById(int $id)
    {
        return $this->prepareResult($this->incomeMapper->findByPk($id));
    }

    /**
     * Fetch all records
     * 
     * @param int $currencyId Optional currency id constraint
     * @return arrau
     */
    public function fetchAll($currencyId = null) : array
    {
        return $this->prepareResults($this->incomeMapper->fetchAll($currencyId));
    }

    /**
     * Deletes a record by its id
     * 
     * @param int $id
     * @return boolean
     */
    public function deleteById(int $id) : bool
    {
        return $this->incomeMapper->deleteByPk($id);
    }

    /**
     * Persists a record
     * 
     * @return boolean
     */
    public function save(array $input) : bool
    {
        return $this->incomeMapper->persist($input);
    }
}
