<?php

use humhub\widgets\GridView;
use humhub\libs\Html;

/** 
 * @var $tagCount int
 * @var $platformStats array
 * @var $platforms array
 */

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t('GamertagModule.base', '<strong>Gamer Tag</strong> Statistics'); ?></h3>
    </div>
    <div class="panel-body">
        
        <h4><?= Yii::t('GamertagModule.base', 'General Statistics'); ?></h4>
        <div class="row">
            <div class="col-md-4">
                <div class="well text-center">
                    <h2><?= Html::encode($tagCount) ?></h2>
                    <p><?= Yii::t('GamertagModule.base', 'Total Gamer Tags'); ?></p>
                </div>
            </div>
        </div>

        <h4><?= Yii::t('GamertagModule.base', 'Platform Statistics'); ?></h4>
        <?= GridView::widget([
            'tableOptions' => ['class' => 'table table-hover'],
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => array_map(function ($platform, $count) use ($platforms) {
                    return [
                        'id' => $platform,
                        'label' => $platforms[$platform]['label'] ?? $platform,
                        'icon' => $platforms[$platform]['icon'] ?? null,
                        'count' => $count,
                    ];
                }, array_keys($platformStats), $platformStats),
                'pagination' => false,
            ]),
            'columns' => [
                [
                    'label' => Yii::t('GamertagModule.base', 'Platform'),
                    'format' => 'raw',
                    'value' => function ($model) {
                        $icon = !empty($model['icon']) ? "<i class='fa " . Html::encode($model['icon']) . "'></i> " : '';
                        return $icon . Html::encode($model['label']);
                    },
                ],
                [
                    'label' => Yii::t('GamertagModule.base', 'Tags Count'),
                    'value' => function ($model) {
                        return $model['count'];
                    },
                ],
            ],
            'emptyText' => Yii::t('GamertagModule.base', 'No gamer tags have been created yet.'),
        ]); ?>

        <div class="alert alert-info">
            <?= Yii::t('GamertagModule.base', 'To add or modify platforms, edit the module configuration file.'); ?>
        </div>
        
    </div>
</div>