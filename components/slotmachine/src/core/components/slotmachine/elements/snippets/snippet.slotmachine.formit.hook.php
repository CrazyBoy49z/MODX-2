<?php
$modx->addPackage('slotmachine', $modx->getOption('core_path') . 'components/slotmachine/model/', 'modx_');

$code = $hook->getValue('code');
$gift = $hook->getValue('gift'); // id подарка + количество активных подарков
$email = $hook->getValue('email');
$office = $hook->getValue('office');


// Проверяем выигрыш
$c = $modx->newQuery('SlotmachineItem');
$c->where(array('active' => 1));
$itemsCount = $modx->getCount('SlotmachineItem', $c);
$arItems = $modx->getCollection('SlotmachineItem', $c);

//$arItems = $modx->getIterator('SlotmachineItem', $c);

$arPrize = array();

foreach ($arItems as $arItem) {
    $arItem = $arItem->toArray();
    if ($arItem['id'] == $gift - $itemsCount) {
        $arPrize = $arItem;
        break;
    }
}

// Если такого id нет или шанс выигрыша  0
if (empty($arPrize) || $arPrize["chance"] == 0) {
    return false;
}


// Сохраняем выигрыш в базу
$prize = $modx->newObject('SlotmachineRequest');

$prize->fromArray(array(
    'office' => $office,
    'email' => $email,
    'code' => $code,
    'gift' => $arPrize["name"]
));
$prize->save();

$hook->setValue('giftname', $arPrize["name"]);

return true;