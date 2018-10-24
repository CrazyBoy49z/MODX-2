<?php

/**
 * The home manager controller for Slotmachine.
 *
 */
class SlotmachineHomeManagerController extends modExtraManagerController
{
    /** @var Slotmachine $Slotmachine */
    public $Slotmachine;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('slotmachine_core_path', null,
                $this->modx->getOption('core_path') . 'components/slotmachine/') . 'model/slotmachine/';
        $this->Slotmachine = $this->modx->getService('slotmachine', 'Slotmachine', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('slotmachine:default');
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('slotmachine');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->Slotmachine->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->Slotmachine->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/slotmachine.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/widgets/requests.grid.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/widgets/requests.windows.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->Slotmachine->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        Slotmachine.config = ' . json_encode($this->Slotmachine->config) . ';
        Slotmachine.config.connector_url = "' . $this->Slotmachine->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "slotmachine-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->Slotmachine->config['templatesPath'] . 'home.tpl';
    }
}