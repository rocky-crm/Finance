<?php

namespace Finance\Service;

use Finance\Storage\MySQL\CurrencyMapper;
use Krystal\Application\Model\AbstractService;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Stdlib\ArrayUtils;

final class CurrencyService extends AbstractService
{
    /**
     * Any compliant currency mapper
     * 
     * @var \Finance\Storage\MySQL\CurrencyMapper
     */
    private $currencyMapper;

    /**
     * State initialization
     * 
     * @param \Finance\Storage\MySQL\CurrencyMapper $currencyMapper
     * @return void
     */
    public function __construct(CurrencyMapper $currencyMapper)
    {
        $this->currencyMapper = $currencyMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'])
               ->setCode($row['code']);

        return $entity;
    }

    /**
     * Fetch records as a list
     * 
     * @return array
     */
    public function fetchList() : array
    {
        return ArrayUtils::arrayList($this->currencyMapper->fetchAll(), 'id', 'code');
    }

    /**
     * Fetch all currencies
     * 
     * @return array
     */
    public function fetchAll() : array
    {
        return $this->prepareResults($this->currencyMapper->fetchAll());
    }

    /**
     * Fetches currency by its id
     * 
     * @param int $id
     * @return mixed
     */
    public function fetchById(int $id)
    {
        return $this->prepareResult($this->currencyMapper->findByPk($id));
    }

    /**
     * Saves currency
     * 
     * @param array $input
     * @return boolean
     */
    public function save(array $input)
    {
        return $this->currencyMapper->persist($input);
    }

    /**
     * Deletes a currency by id
     * 
     * @param int $id Currency id
     * @return boolean
     */
    public function deleteById(int $id)
    {
        return $this->currencyMapper->deleteByPk($id);
    }
}
