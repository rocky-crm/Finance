<?php

namespace Finance\Storage\MySQL;

use Krystal\Db\Sql\AbstractMapper;

final class CalendarMapper extends AbstractMapper
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName() : string
    {
        return 'rocky_finance_calendar';
    }

    /**
     * {@inheritDoc}
     */
    protected function getPk() : string
    {
        return 'id';
    }

    /**
     * Counts total amount by specific date
     * 
     * @param int $currencyId Attached currency id
     * @param string $date Optional date constraint
     * @return float
     */
    public function getSum(int $currencyId, $date) : float
    {
        $db = $this->db->select()
                       ->sum('amount')
                       ->from(self::getTableName())
                       ->whereEquals('currency_id', $currencyId);

        // Apply if required
        if ($date !== null) {
            $db->andWhereEquals('date', $date);
        }

        return (float) $db->queryScalar();
    }

    /**
     * Returns all calendar entries
     * 
     * @param int $currencyId Attached currency id
     * @param string $date Optional date constraint
     * @return array
     */
    public function fetchAll(int $currencyId, $date) : array
    {
        // Columns to be selected
        $columns = [
            self::column('id'),
            self::column('spending_id'),
            SpendingMapper::column('name') => 'spending',
            self::column('date'),
            self::column('name'),
            self::column('amount'),
            CurrencyMapper::column('code') => 'currency'
        ];

        $db = $this->db->select($columns)
                       ->from(self::getTableName())
                       // Spending relation
                       ->leftJoin(SpendingMapper::getTableName(), [
                            SpendingMapper::column('id') => self::getRawColumn('spending_id')
                       ])
                       // Currency relation
                       ->leftJoin(CurrencyMapper::getTableName(), [
                            CurrencyMapper::column('id') => self::getRawColumn('currency_id')
                       ])
                       // Currency ID constraint
                       ->whereEquals(self::column('currency_id'), $currencyId);

        // Apply if required
        if ($date !== null) {
            $db->andWhereEquals(self::column('date'), $date);
        }

        $db->orderBy($this->getPk())
           ->desc();

        return $db->queryAll();
    }
}
