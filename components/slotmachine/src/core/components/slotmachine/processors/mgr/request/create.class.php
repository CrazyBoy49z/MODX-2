<?php

class SlotmachineRequestCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'SlotmachineRequest';
    public $classKey = 'SlotmachineRequest';
    public $languageTopics = array('slotmachine');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        return parent::beforeSet();
    }

}

return 'SlotmachineRequestCreateProcessor';