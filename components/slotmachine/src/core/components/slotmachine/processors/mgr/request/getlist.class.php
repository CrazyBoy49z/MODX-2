<?php

class SlotmachineRequestGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'SlotmachineRequest';
    public $classKey = 'SlotmachineRequest';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where(array(
                'office:LIKE' => "%{$query}%",
                'OR:email:LIKE' => "%{$query}%",
                'OR:code:LIKE' => "%{$query}%",
                'OR:gift:LIKE' => "%{$query}%",
            ));
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = array();

        // Edit
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('slotmachine_request_update'),
            //'multiple' => $this->modx->lexicon('slotmachine_requests_update'),
            'action' => 'updateRequest',
            'button' => true,
            'menu' => true,
        );

        if (!$array['active']) {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('slotmachine_request_enable'),
                'multiple' => $this->modx->lexicon('slotmachine_requests_enable'),
                'action' => 'enableRequest',
                'button' => true,
                'menu' => true,
            );
        } else {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('slotmachine_request_disable'),
                'multiple' => $this->modx->lexicon('slotmachine_requests_disable'),
                'action' => 'disableRequest',
                'button' => true,
                'menu' => true,
            );
        }

        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('slotmachine_request_remove'),
            'multiple' => $this->modx->lexicon('slotmachine_requests_remove'),
            'action' => 'removeRequest',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }

}

return 'SlotmachineRequestGetListProcessor';