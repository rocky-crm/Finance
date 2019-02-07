<?php

namespace Finance\Storage\MySQL;

use Krystal\Db\Sql\AbstractMapper;

final class CurrencyMapper extends AbstractMapper
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName() : string
    {
        return 'rocky_finance_currency';
    }

    /**
     * {@inheritDoc}
     */
    protected function getPk() : string
    {
        return 'id';
    }

    /**
     * Fetch all currencies
     * 
     * @return array
     */
    public function fetchAll() : array
    {
        $db = $this->db->select('*')
                       ->from(self::getTableName())
                       ->orderBy($this->getPk())
                       ->desc();

        return $db->queryAll();
    }
}
