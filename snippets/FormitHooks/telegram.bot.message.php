<?php
$access_token = '';
$chat_id = '';
$api = 'https://api.telegram.org/bot' . $access_token . '/sendMessage?chat_id=' . $chat_id . '&text=';

$allFormFields = $hook->getValues();

if (!empty($allFormFields) && is_array($allFormFields) && $allFormFields['type'] == 'form') {

    $message = '';

    switch ($allFormFields['form']) {

        // Оформить заявку
        case 'order_form' :

            $arNames = array(
                'name' => 'Имя',
                'contact' => 'Телефон',
                'model' => 'Модель',
                'office' => 'Офис',
                'master' => 'Выезд мастера',
                'text' => 'Неисправность',
                'date' => 'Дата приезда'
            );
            $message = "Новая заявка на ремонт!\r\n";
            break;

        // Вызов мастера
        case 'courier_form' :

            $arNames = array(
                'name' => 'Имя',
                'phone' => 'Телефон',
                'office' => 'Офис'
            );
            $message = "Новый вызов мастера!\r\n";
            break;
    }

    foreach ($allFormFields as $key => $val) {

        if (empty($val) || in_array($key, array('type', 'form', 'courier', 'order', 'emailAddress', 'g-recaptcha-response'))) {
            continue;
        }

        $message .= $arNames[$key] . ': ' . $val . "\r\n";
    }

    file_get_contents($api . urlencode($message));
}

return true;