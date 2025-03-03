<?php

namespace humhub\modules\gamertag\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\gamertag\models\GamerTag;
use Yii;

/**
 * Admin controller for the gamertag module
 */
class AdminController extends Controller
{
    /**
     * Renders the admin settings page
     */
    public function actionIndex()
    {
        $tagCount = (int) GamerTag::find()->count();
        $platforms = Yii::$app->getModule('gamertag')->getPlatforms();

        $platformStats = [];
        foreach (array_keys($platforms) as $platform) {
            $platformStats[$platform] = GamerTag::find()->where(['platform' => $platform])->count();
        }

        // Sort platforms by usage
        arsort($platformStats);

        return $this->render('index', [
            'tagCount' => $tagCount,
            'platformStats' => $platformStats,
            'platforms' => $platforms
        ]);
    }
}