<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var Slotmachine $Slotmachine */

if (!$Slotmachine = $modx->getService('slotmachine', 'Slotmachine', $modx->getOption('slotmachine_core_path', null,
        $modx->getOption('core_path') . 'components/slotmachine/') . 'model/slotmachine/', $scriptProperties)
) {
    return "Class not loaded!";
}

// Load scripts and css
$modx->regClientCSS(MODX_ASSETS_URL . 'components/slotmachine/css/web/slotmachine.css');
$modx->regClientScript(MODX_ASSETS_URL . 'components/slotmachine/js/web/jquery.slotmachine.js');
$modx->regClientScript(MODX_ASSETS_URL . 'components/slotmachine/js/web/slots.min.js');

// Scriptproperties
$tpl = $modx->getOption('tpl', $scriptProperties, 'Item');
$main_tpl = $modx->getOption('main_tpl', $scriptProperties, 'Item');

// Build query
$c = $modx->newQuery('SlotmachineItem');
$c->sortby('id', 'ASC');
$c->where(array('active' => 1));
$items = $modx->getIterator('SlotmachineItem', $c);

// Iterate through items
$list = array();
foreach ($items as $item) {
    $list[] = $modx->getChunk($tpl, $item->toArray());
}
$output = implode("\n", $list);

$modx->setPlaceholder('slot_items', $output);

$output = $modx->getChunk($main_tpl, array());

return $output;