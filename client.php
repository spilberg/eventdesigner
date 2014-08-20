<?php

/**
* @desc SOAP client
*/

// Подключаем код NuSOAP
require_once('lib/nusoap.php');
// Создаем экземпляр клиента
$client = new soapclient('http://eventdesigner/ed.php?wsdl', true); 
//$client = new soapclient('http://nusoap/helloworld.php');

// Проверяем, не произошла ли ошибка.
$err = $client->getError();
if ($err) {
    // Отображаем ошибку
    echo '<p><b>Ошибка в конструкторе класса: ' . $err . '</b></p>';
    // Теперь мы уже знаем, что следующий вызов будет неудачным.
} 
// Вызываем SOAP-метод
$result = $client->call('getActorList');

// Проверяем, ни возник-ли сбой
if ($client->fault) {
    echo '<p><b>Сбой: ';
    print_r($result);
    echo '</b></p>';
} else {
    // Проверяем, ни возникла ли ошибка
    $err = $client->getError();
    if ($err) {
        // Оторажаем ошибку
        echo '<p><b>Ошибка: ' . $err . '</b></p>';
    } else {
        // Отображаем результат
        echo '<h2>Результат</h2><pre>';
        print_r($result);
    echo '</pre>';
    }
}
// Отображаем запрос и ответ
echo '<h2>Запрос</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Отает</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
// Отображаем отладочные сообщения
echo '<h2>Отладка</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>'; 



?>
