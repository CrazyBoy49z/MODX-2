<?php

class SlotmachineRequestRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'SlotmachineRequest';
    public $classKey = 'SlotmachineRequest';
    public $languageTopics = array('slotmachine');
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('slotmachine_request_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var SlotmachineRequest $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('slotmachine_request_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'SlotmachineRequestRemoveProcessor';