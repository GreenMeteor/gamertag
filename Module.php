<?php

namespace humhub\modules\gamertag;

use Yii;
use yii\helpers\Url;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\components\Module as BaseModule;
use humhub\modules\content\components\ContentContainerActiveRecord;

/**
 * GamerTag Module Definition
 */
class Module extends BaseModule
{
    public function getConfigUrl()
    {
        return Url::to(['/gamertag/admin']);
    }

    public function disable()
    {
        foreach (models\GamerTag::find()->all() as $tag) {
            $tag->delete();
        }
        parent::disable();
    }

    public function enableContentContainer(ContentContainerActiveRecord $container)
    {
        if ($container instanceof User) {
            parent::enableContentContainer($container);
        }
    }

    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        if ($container instanceof User) {
            parent::disableContentContainer($container);
        }
    }

    public static function getPlatforms()
    {
        return [
            'xbox' => [
                'label' => 'Xbox',
                'icon' => 'fas fa-xbox',
                'color' => '#107C10'
            ],
            'playstation' => [
                'label' => 'PlayStation',
                'icon' => 'fas fa-playstation',
                'color' => '#003791'
            ],
            'nintendo' => [
                'label' => 'Nintendo',
                'icon' => 'fas fa-gamepad',
                'color' => '#E60012'
            ],
            'steam' => [
                'label' => 'Steam',
                'icon' => 'fab fa-steam',
                'color' => '#171A21'
            ],
            'epic' => [
                'label' => 'Epic Games',
                'icon' => 'fas fa-store',
                'color' => '#2F2D2E'
            ],
            'ea' => [
                'label' => 'EA',
                'icon' => 'fas fa-gamepad',
                'color' => '#FF4747'
            ],
            'battlenet' => [
                'label' => 'Battle.net',
                'icon' => 'fas fa-network-wired',
                'color' => '#00AEFF'
            ],
            'ubisoft' => [
                'label' => 'Ubisoft',
                'icon' => 'fas fa-gamepad',
                'color' => '#0070FF'
            ],
            'gog' => [
                'label' => 'GOG',
                'icon' => 'fas fa-gamepad',
                'color' => '#5D2E8C'
            ],
            'riot' => [
                'label' => 'Riot Games',
                'icon' => 'fas fa-bolt',
                'color' => '#D13639'
            ],
            'discord' => [
                'label' => 'Discord',
                'icon' => 'fab fa-discord',
                'color' => '#5865F2'
            ],
            'minecraft' => [
                'label' => 'Minecraft',
                'icon' => 'fas fa-cube',
                'color' => '#62B47A'
            ],
            'other' => [
                'label' => 'Other',
                'icon' => 'fas fa-gamepad',
                'color' => '#777777'
            ]
        ];
    }
}