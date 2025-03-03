<?php

use humhub\modules\gamertag\models\GamerTag;
use humhub\widgets\ActiveForm;
use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var GamerTag $model */
/** @var array $platforms */
/** @var humhub\modules\user\models\User $user */

?>

<?php ModalDialog::begin([
    'header' => Yii::t('GamertagModule.base', '<strong>Add</strong> Gaming Profile'),
    'size' => 'medium',
]) ?>

    <?php $form = ActiveForm::begin(['id' => 'gamertag-form']); ?>

        <div class="modal-body">
            <?= $form->field($model, 'platform')->dropDownList(array_map(function($platform) {
                return $platform['label'];
            }, $platforms), [
                'prompt' => Yii::t('GamertagModule.base', 'Select platform')
            ]); ?>

            <?= $form->field($model, 'gamertag'); ?>

            <?= $form->field($model, 'visibility')->dropDownList(GamerTag::getVisibilityOptions()); ?>

            <div class="help-block">
                <?= Yii::t('GamertagModule.base', 'Note: Your gaming profile visibility controls who can see your gamertag on your profile.'); ?>
            </div>
        </div>

        <div class="modal-footer">
            <?= ModalButton::submitModal(Url::to([$user->createUrl('/gamertag/profile/create'),
                'id' => $model->id,
            ]), Yii::t('GamertagModule.base', 'Add')); ?>
            <?= ModalButton::cancel(); ?>
        </div>

    <?php ActiveForm::end(); ?>

<?php ModalDialog::end(); ?>
