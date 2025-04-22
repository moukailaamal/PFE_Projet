<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | Cette option définit le broadcaster par défaut qui sera utilisé par le 
    | framework lorsque qu'un événement doit être diffusé. Tu peux le définir
    | à l'un des drivers disponibles dans l'array "connections" ci-dessous.
    |
    | Options supportées : "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'pusher'),  // Définit Pusher comme broadcaster par défaut

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Ici tu peux définir toutes les connexions de diffusion qui seront utilisées
    | pour diffuser les événements vers d'autres systèmes ou via des websockets.
    | Des exemples pour chaque type de connexion sont fournis dans cet array.
    |
    */

   'connections' => [
    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ],
    ],
],


];
