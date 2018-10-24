<?php

class SlotmachineOfficeItemGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'SlotmachineItem';
    public $classKey = 'SlotmachineItem';
    public $languageTopics = array('slotmachine:default');
    //public $permission = 'view';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return mixed
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        return parent::process();
    }

}

return 'SlotmachineOfficeItemGetProcessor';