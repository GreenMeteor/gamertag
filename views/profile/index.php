<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use humhub\modules\user\models\User;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\modules\gamertag\assets\Assets;
use humhub\modules\gamertag\models\GamerTag;

/** @var User $user */
/** @var GamerTag[] $tags */
/** @var bool $canEdit */

$assets = Assets::register($this);

$this->title = Yii::t('GamertagModule.base', 'Gaming Profiles');
$this->pageTitle = $this->title;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('GamertagModule.base', '<strong>Gaming</strong> Profiles'); ?>
    </div>
    <div class="panel-body">
        <?php if ($canEdit): ?>
            <?= Html::a(
                Icon::get('plus') . Yii::t('GamertagModule.base', 'Add Gaming Profile'),
                [$user->createUrl('/gamertag/profile/create')],
                [
                    'class' => 'btn btn-primary btn-sm pull-right',
                    'data-toggle' => 'modal',
                    'data-target' => '#globalModal'
                ]
            ); ?>
        <?php endif; ?>
    </div>

    <div class="panel-body">
        <?php if (empty($tags)): ?>
            <div class="alert alert-info text-center">
                <strong><?= Yii::t('GamertagModule.base', 'No gaming profiles added yet.'); ?></strong>
            </div>
        <?php else: ?>
            <div class="row">
                <?php 
                $count = 0;
                foreach ($tags as $tag): 
                    $platformData = $tag->getPlatformData();
                    // Start a new row after every 3 items
                    if ($count > 0 && $count % 3 == 0) {
                        echo '</div><div class="row">';
                    }
                    $count++;
                ?>
                    <div class="col-md-4">
                        <div class="gaming-profile-container" data-platform="<?= Html::encode(strtolower($platformData['label'] ?? '')); ?>">
                            <div class="platform-header" style="background-color: <?= $platformData['color']; ?>;">
                                <div class="platform-icon">
                                    <?= Icon::get($platformData['icon']); ?>
                                </div>
                                <span class="platform-name"><?= Html::encode($platformData['label']); ?></span>
                                
                                <?php if ($canEdit): ?>
                                    <div class="platform-actions">
                                        <?= Html::a(Icon::get('pencil'), 
                                            [$user->createUrl('/gamertag/profile/update', ['id' => $tag->id])], 
                                            ['class' => 'btn btn-xs edit-btn', 'data-toggle' => 'modal', 'data-target' => '#globalModal']
                                        ); ?>
                                        <?= Html::a(Icon::get('trash'), 
                                            [$user->createUrl('/gamertag/profile/delete', ['id' => $tag->id])], 
                                            [
                                                'class' => 'btn btn-xs delete-btn',
                                                'data-method' => 'post',
                                                'data-confirm' => Yii::t('GamertagModule.base', 'Are you sure?')
                                            ]
                                        ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?= DetailView::widget([
                                'model' => $tag,
                                'options' => [
                                    'class' => 'detail-view gaming-detail-view',
                                ],
                                'attributes' => [
                                    [
                                        'label' => Yii::t('GamertagModule.base', 'Gamertag'),
                                        'value' => $tag->gamertag,
                                        'contentOptions' => ['class' => 'gamertag-value'],
                                    ],
                                    [
                                        'label' => Yii::t('GamertagModule.base', 'Visibility'),
                                        'value' => GamerTag::getVisibilityOptions()[$tag->visibility],
                                        'contentOptions' => ['class' => 'visibility-value'],
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>