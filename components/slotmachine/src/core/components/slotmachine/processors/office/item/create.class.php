<?php

class SlotmachineOfficeItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'SlotmachineItem';
    public $classKey = 'SlotmachineItem';
    public $languageTopics = array('slotmachine');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('slotmachine_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('slotmachine_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'SlotmachineOfficeItemCreateProcessor';