<?php

namespace humhub\modules\gamertag;

use Yii;
use yii\base\Event;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\modules\user\widgets\ProfileMenu;

/**
 * Event Handlers for the Gamertag Module
 */
class Events
{
    /**
     * Adds the gamertag menu item to the profile menu
     */
    public static function onProfileMenuInit(Event $event)
    {
        /* @var ProfileMenu $event */
        $menu = $event->sender;
        $user = $menu->user;

        // Check if the module is enabled
        if ($user && Yii::$app->getModule('gamertag')) {
            $menu->addEntry(new MenuLink([
                'label' => Yii::t('GamertagModule.base', 'Gaming Profiles'),
                'url' => $user->createUrl('/gamertag/profile/index'),
                'icon' => Icon::get('gamepad'),
                'isActive' => MenuLink::isActiveState('gamertag', 'profile'),
                'isVisible' => true,
                'sortOrder' => 300,
            ]));
        }
    }
}