<?php

namespace humhub\modules\gamertag\controllers;

use humhub\modules\content\components\ContentContainerController;
use humhub\modules\gamertag\models\GamerTag;
use humhub\modules\user\models\User;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * GamerTag Controller for the user profile
 */
class ProfileController extends ContentContainerController
{
    /**
     * Lists all gamer tags for a user profile
     */
    public function actionIndex()
    {
        $user = $this->contentContainer;
        $tags = GamerTag::find()
            ->where(['user_id' => $user->id])
            ->all();

        $viewableTags = [];
        foreach ($tags as $tag) {
            if ($tag->canView()) {
                $viewableTags[] = $tag;
            }
        }

        return $this->render('index', [
            'tags' => $viewableTags,
            'user' => $user,
            'canEdit' => $user->id == Yii::$app->user->id
        ]);
    }

    /**
     * Creates a new gamer tag
     */
    public function actionCreate()
    {
        $user = $this->contentContainer;
        
        // Check if user is allowed to create tags
        if ($user->id != Yii::$app->user->id) {
            throw new HttpException(403, 'You are not allowed to manage this user\'s gamer tags!');
        }

        $model = new GamerTag();
        $model->user_id = $user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->success(Yii::t('GamertagModule.base', 'Gamer tag has been added.'));
            return $this->redirect([$user->createUrl('/gamertag/profile/index')]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'user' => $user,
            'platforms' => Yii::$app->getModule('gamertag')->getPlatforms()
        ]);
    }

    /**
     * Updates an existing gamer tag
     */
    public function actionUpdate($id)
    {
        $user = $this->contentContainer;
        $model = $this->findModel($id);

        // Check if user is allowed to update tags
        if ($user->id != Yii::$app->user->id || $model->user_id != $user->id) {
            throw new HttpException(403, 'You are not allowed to manage this gamer tag!');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->success(Yii::t('GamertagModule.base', 'Gamer tag has been updated.'));
            return $this->redirect([$user->createUrl('/gamertag/profile/index')]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'user' => $user,
            'platforms' => Yii::$app->getModule('gamertag')->getPlatforms()
        ]);
    }

    /**
     * Deletes an existing gamer tag
     */
    public function actionDelete($id)
    {
        $user = $this->contentContainer;
        $model = $this->findModel($id);

        // Check if user is allowed to delete tags
        if ($user->id != Yii::$app->user->id || $model->user_id != $user->id) {
            throw new HttpException(403, 'You are not allowed to manage this gamer tag!');
        }

        $model->delete();
        $this->view->success(Yii::t('GamertagModule.base', 'Gamer tag has been deleted.'));
        
        return $this->redirect([$user->createUrl('/gamertag/profile/index')]);
    }

    /**
     * Finds the GamerTag model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = GamerTag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested gamer tag does not exist.');
    }
}