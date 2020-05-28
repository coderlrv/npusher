### NPusher - Envio de notificação push para API-Firebase.

[Firebase](https://console.firebase.google.com/project/)

[Doc API](https://firebase.google.com/docs/cloud-messaging/send-message)


## Instalação

~~~
composer require preflrv/npusher
~~~

## Como utilizar

~~~ php

use NPusher\NPusher;


// FIREBASE_APIKEY de acesso api firebase;
// 
$apiKey = 'babf40b8-7727-4c70-aaf9-e9fea28a4eea';
$pusher = new NPusher($apiKey);


//Configurações
$tokenDevice = '545454646464'  // Token do device a se recebindo msg.

$config = [
    'sound'         => 'default',
    'priority'      => 'high',
    'adicionalData' => [
        'foreground' => true
    ],
    'notification'  => [
        'body'            => 'Texto notifição', 
        'title'           => 'Titulo da notificação',
    ]
];


//Envia notificação.
$pusher->notify($tokenDevice,$config);

~~~