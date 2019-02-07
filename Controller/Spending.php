<?php

namespace Finance\Controller;

use Krystal\Stdlib\VirtualEntity;
use Site\Controller\AbstractCrmController;

final class Spending extends AbstractCrmController
{
    /**
     * Renders all items
     * 
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
        return $this->view->render('spending', [
            'spendings' => $this->getModuleService('spendingService')->fetchAll(),
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
        $entity = $this->getModuleService('spendingService')->fetchById($id);

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
    public function saveAction() : int
    {
        $input = $this->request->getPost();

        $this->getModuleService('spendingService')->save($input);
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
        $this->getModuleService('spendingService')->deleteById($id);

        return $this->response->back();
    }
}
