<?php

namespace Finance\Storage\MySQL;

use Krystal\Db\Sql\AbstractMapper;

final class IncomeMapper extends AbstractMapper
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName() : string
    {
        return 'rocky_finance_income';
    }

    /**
     * {@inheritDoc}
     */
    protected function getPk() : string
    {
        return 'id';
    }

    /**
     * Fetch all records
     * 
     * @return array
     */
    public function fetchAll() : array
    {
        $columns = [
            self::column('id'),
            self::column('currency_id'),
            self::column('from'),
            self::column('date'),
            self::column('amount'),
            self::column('comment'),
            CurrencyMapper::column('code') => 'currency',
        ];

        $db = $this->db->select($columns)
                       ->from(self::getTableName())
                       // Currency relation
                       ->leftJoin(CurrencyMapper::getTableName(), [
                            CurrencyMapper::column('id') => self::getRawColumn('currency_id')
                       ])
                       ->orderBy($this->getPk())
                       ->desc();

        return $db->queryAll();
    }
}
