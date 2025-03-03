<?php

use humhub\modules\gamertag\Events;
use humhub\modules\gamertag\Module;
use humhub\modules\user\widgets\ProfileMenu;

return [
    'id' => 'gamertag',
    'class' => Module::class,
    'namespace' => 'humhub\modules\gamertag',
    'events' => [
        ['class' => ProfileMenu::class, 'event' => ProfileMenu::EVENT_INIT, 'callback' => [Events::class, 'onProfileMenuInit']],
    ],
];