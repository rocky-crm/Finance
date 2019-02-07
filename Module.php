<?php

namespace Finance;

use Krystal\Application\Module\AbstractModule;
use Finance\Service\SpendingService;
use Finance\Service\CalendarService;
use Finance\Service\IncomeService;
use Finance\Service\CurrencyService;

final class Module extends AbstractModule
{
    /**
     * Returns routes of this module
     * 
     * @return array
     */
    public function getRoutes() : array
    {
        return include(__DIR__) . '/Config/routes.php';
    }

    /**
     * Returns prepared service instances of this module
     * 
     * @return array
     */
    public function getServiceProviders() : array
    {
        return [
            'spendingService' => new SpendingService($this->createMapper('\Finance\Storage\MySQL\SpendingMapper')),
            'calendarService' => new CalendarService($this->createMapper('\Finance\Storage\MySQL\CalendarMapper')),
            'incomeService' => new IncomeService($this->createMapper('\Finance\Storage\MySQL\IncomeMapper')),
            'currencyService' => new CurrencyService($this->createMapper('\Finance\Storage\MySQL\CurrencyMapper'))
        ];
    }
}
