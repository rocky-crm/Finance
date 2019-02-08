<?php

namespace Finance\Service;

use Finance\Storage\MySQL\CalendarMapper;
use Krystal\Application\Model\AbstractService;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Stdlib\ArrayUtils;
use Krystal\Date\TimeHelper;

final class CalendarService extends AbstractService
{
    /**
     * Calendar mapper instance
     * 
     * @var \Finance\Storage\MySQL\CalendarMapper
     */
    private $calendarMapper;

    /**
     * State initialization
     * 
     * @param \Finance\Storage\MySQL\CalendarMapper $calendarMapper
     * @return void
     */
    public function __construct(CalendarMapper $calendarMapper)
    {
        $this->calendarMapper = $calendarMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'])
               ->setSpendingId($row['spending_id'])
               ->setSpending($row['spending'] ?? null)
               ->setCurrencyId($row['currency_id'] ?? null)
               ->setDate($row['date'])
               ->setComment($row['comment'])
               ->setAmount($row['amount']);

        if (isset($row['currency'])) {
            $entity->setCurrency($row['currency']);
        }

        return $entity;
    }

    /**
     * Parse raw data to be converted to pivot
     * 
     * @param array $rows
     * @return array
     */
    public static function parsePivotData(array $rows) : array
    {
        $output = [];
        $partition = ArrayUtils::arrayPartition($rows, 'date', false);

        // Counters
        $total = 0;
        $spendings = 0;
        $currency = null;

        foreach ($partition as $date => $details) {
            $amounts = array_column($details, 'amount');
            $sum = array_sum($amounts);

            // Increment total counter
            $total += $sum;
            $spendings += count($details);

            $output[] = [
                'date' => $date,
                'sum' => $sum,
                'details' => $details
            ];

            // Generate currency
            $currency = array_unique(array_column($details, 'currency'))[0];
        }

        return [
            'currency' => $currency,
            'total' => $total,
            'spendings' => $spendings,
            'data' => $output
        ];
    }

    /**
     * Creates pivot data
     * 
     * @param int $currencyId Attached currency id
     * @return array
     */
    public function getPivotData(int $currencyId) : array
    {
        return self::parsePivotData($this->calendarMapper->fetchAll($currencyId, null));
    }

    /**
     * Counts total amount by specific date
     * 
     * @param int $currencyId Attached currency id
     * @param string $date Optional date constraint
     * @return float
     */
    public function getSum(int $currencyId, $date = null)
    {
        $sum = $this->calendarMapper->getSum($currencyId, $date);

        return number_format($sum);
    }

    /**
     * Fetch finance calendar
     * 
     * @param int $currencyId Attached currency id
     * @param string $date Optional date constraint. Defaults to today
     * @return array
     */
    public function fetchAll(int $currencyId, $date = null) : array
    {
        if ($date === null) {
            $date = TimeHelper::getNow(false);
        }

        return $this->prepareResults($this->calendarMapper->fetchAll($currencyId, $date));
    }

    /**
     * Fetch calendar item by its ID
     * 
     * @param int $id
     * @return mixed
     */
    public function fetchById(int $id)
    {
        return $this->prepareResult($this->calendarMapper->findByPk($id));
    }

    /**
     * Deletes record by its id
     * 
     * @param int $id
     * @return boolean
     */
    public function deleteById(int $id) : bool
    {
        return $this->calendarMapper->deleteByPk($id);
    }

    /**
     * Persists a record
     * 
     * @param array $input
     * @return boolean
     */
    public function save(array $input)
    {
        return $this->calendarMapper->persist($input);
    }
}
