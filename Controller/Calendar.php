<?php

namespace Finance\Controller;

use Krystal\Date\TimeHelper;
use Krystal\Stdlib\VirtualEntity;
use Site\Controller\AbstractCrmController;

final class Calendar extends AbstractCrmController
{
    /**
     * Renders pivot table
     * 
     * @return string
     */
    public function pivotAction() : string
    {
        $currencyId = $this->request->getQuery('currency_id', 1);

        return $this->view->render('pivot', [
            'data' => $this->getModuleService('calendarService')->getPivotData($currencyId),
            'currencies' => $this->getModuleService('currencyService')->fetchList(),
            'currencyId' => $currencyId
        ]);
    }

    /**
     * Renders all items
     * 
     * @param string $date
     * @param mixed $currencyId Optional currency ID constraint
     * @return string
     */
    public function indexAction($date = null, $currencyId = null) : string
    {
        if ($date === null) {
            $date = TimeHelper::getNow(false);
        }

        if ($currencyId === null) {
            $currencyId = 1;
        }

        $entity = new VirtualEntity;
        $entity->setDate($date);

        return $this->createGrid($entity, $date, $currencyId);
    }

    /**
     * Explore by date and currency
     * 
     * @param string $date
     * @return string
     */
    public function exploreAction() : string
    {
        $date = $this->request->getQuery('date');
        $currencyId = $this->request->getQuery('currency_id');

        return $this->indexAction($date, $currencyId);
    }

    /**
     * Creates a grid
     * 
     * @param \Krystal\Stdlib\VirtualEntity $entity
     * @param mixed $date Optional date override. Defaults to today
     * @param mixed $currencyId Optional currency ID constraint
     * @return string
     */
    private function createGrid(VirtualEntity $entity, $date = null, $currencyId = null) : string
    {
        return $this->view->render('calendar', [
            // Request parameters
            'date' => $date,
            'currencyId' => $currencyId,

            'calendar' => $this->getModuleService('calendarService')->fetchAll($currencyId, $date),
            'currencies' => $this->getModuleService('currencyService')->fetchList(),
            'sum' => $this->getModuleService('calendarService')->getSum($currencyId, $date),
            'spendings' => $this->getModuleService('spendingService')->fetchList(),
            'entity' => $entity
        ]);
    }

    /**
     * Renders edit form
     * 
     * @param int $id
     * @return mixed
     */
    public function editAction(int $id)
    {
        $entity = $this->getModuleService('calendarService')->fetchById($id);

        if ($entity) {
            return $this->createGrid($entity, null, $entity->getCurrencyId());
        } else {
            return false;
        }
    }

    /**
     * Saves data
     * 
     * @return mixed
     */
    public function saveAction() : int
    {
        $input = $this->request->getPost();

        $this->getModuleService('calendarService')->save($input);
        return 1;
    }

    /**
     * Deletes an item
     * 
     * @param int $id
     * @return void
     */
    public function deleteAction(int $id) : void
    {
        $this->getModuleService('calendarService')->deleteById($id);

        return $this->response->back();
    }
}
