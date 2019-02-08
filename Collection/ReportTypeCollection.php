<?php

namespace Finance\Collection;

use Krystal\Stdlib\ArrayCollection;

final class ReportTypeCollection extends ArrayCollection
{
    const TYPE_SPEND = 1;
    const TYPE_INCOME = 2;

    /**
     * {@inheritDoc}
     */
    protected $collection = [
        self::TYPE_SPEND => 'Spendings',
        self::TYPE_INCOME => 'Incomes'
    ];
}
