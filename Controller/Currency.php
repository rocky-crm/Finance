<?php

namespace Finance\Controller;

use Krystal\Date\TimeHelper;
use Krystal\Stdlib\VirtualEntity;
use Site\Controller\AbstractCrmController;

final class Currency extends AbstractCrmController
{
    /**
     * Renders all records
     * 
     * @param string $date
     * @return string
     */
    public function indexAction() : string
    {
        return $this->createGrid(new VirtualEntity);
    }

    /**
     * Creates a grid
     * 
     * @param \Krystal\Stdlib\VirtualEntity $entity
     * @return string
     */
    private function createGrid(VirtualEntity $entity) : string
    {
        return $this->view->render('currency', [
            'currencies' => $this->getModuleService('currencyService')->fetchAll(),
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
        $entity = $this->getModuleService('currencyService')->fetchById($id);

        if ($entity) {
            return $this->createGrid($entity);
        } else {
            return false;
        }
    }

    /**
     * Saves data
     * 
     * @return mixed
     */
    public function saveAction()
    {
        $input = $this->request->getPost();

        $this->getModuleService('currencyService')->save($input);
        return 1;
    }

    /**
     * Deletes a record
     * 
     * @param int $id
     * @return void
     */
    public function deleteAction(int $id)
    {
        $this->getModuleService('currencyService')->deleteById($id);

        return $this->response->back();
    }
}
