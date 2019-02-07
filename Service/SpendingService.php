<?php

namespace Finance\Service;

use Finance\Storage\MySQL\SpendingMapper;
use Krystal\Application\Model\AbstractService;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Stdlib\ArrayUtils;

final class SpendingService extends AbstractService
{
    /**
     * Spending mapper instance
     * 
     * @var \Finance\Storage\MySQL\SpendingMapper
     */
    private $spendingMapper;

    /**
     * State initialization
     * 
     * @param \Finance\Storage\MySQL\SpendingMapper $spendingMapper
     * @return void
     */
    public function __construct(SpendingMapper $spendingMapper)
    {
        $this->spendingMapper = $spendingMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row) : VirtualEntity
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'])
               ->setName($row['name']);

        return $entity;
    }

    /**
     * Fetch a spending by its ID
     * 
     * @param int $id
     * @return mixed
     */
    public function fetchById(int $id)
    {
        return $this->prepareResult($this->spendingMapper->findByPk($id));
    }

    /**
     * Fetch all spending as a list
     * 
     * @return arrau
     */
    public function fetchList()
    {
        return ArrayUtils::arrayList($this->spendingMapper->fetchAll(), 'id', 'name');
    }

    /**
     * Fetch all spendings
     * 
     * @return array
     */
    public function fetchAll() : array
    {
        return $this->prepareResults($this->spendingMapper->fetchAll());
    }

    /**
     * Deletes spending by its ID
     * 
     * @return boolean
     */
    public function deleteById(int $id) : bool
    {
        return $this->spendingMapper->deleteByPk($id);
    }

    /**
     * Persist a spending
     * 
     * @param array $input
     * @return boolean
     */
    public function save(array $input) : bool
    {
        return $this->spendingMapper->persist($input);
    }
}
