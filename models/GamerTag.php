<?php

namespace humhub\modules\gamertag\models;

use Yii;
use humhub\components\ActiveRecord;
use humhub\modules\user\models\User;

/**
 * GamerTag model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $platform
 * @property string $gamertag
 * @property string $visibility
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class GamerTag extends ActiveRecord
{
    const VISIBILITY_PRIVATE = 'private';
    const VISIBILITY_MEMBERS = 'members';
    const VISIBILITY_PUBLIC = 'public';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gamertag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'platform', 'gamertag'], 'required'],
            ['platform', 'in', 'range' => array_keys(Yii::$app->getModule('gamertag')->getPlatforms())],
            ['gamertag', 'string', 'max' => 64],
            ['visibility', 'in', 'range' => [self::VISIBILITY_PRIVATE, self::VISIBILITY_MEMBERS, self::VISIBILITY_PUBLIC]],
            ['visibility', 'default', 'value' => self::VISIBILITY_MEMBERS],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'platform' => 'Platform',
            'gamertag' => 'Gamertag',
            'visibility' => 'Visibility',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Returns visibility options
     */
    public static function getVisibilityOptions()
    {
        return [
            self::VISIBILITY_PRIVATE => Yii::t('GamertagModule.base', 'Private - Only me'),
            self::VISIBILITY_MEMBERS => Yii::t('GamertagModule.base', 'Members - Only registered users'),
            self::VISIBILITY_PUBLIC => Yii::t('GamertagModule.base', 'Public - Everyone'),
        ];
    }

    /**
     * Check if the current user can view this gamer tag
     */
    public function canView()
    {
        if (Yii::$app->user->isAdmin()) {
            return true;
        }

        // Owner can always view
        if (Yii::$app->user->id == $this->user_id) {
            return true;
        }

        // Public visibility
        if ($this->visibility == self::VISIBILITY_PUBLIC) {
            return true;
        }

        // Members only visibility
        if ($this->visibility == self::VISIBILITY_MEMBERS && !Yii::$app->user->isGuest) {
            return true;
        }

        return false;
    }

    /**
     * Fetch the gamertag specifically for the current user, ensuring it's user-scoped
     */
    public static function findByUser($userId)
    {
        return self::find()->where(['user_id' => $userId])->all();
    }

    /**
     * Returns the platform data for this gamer tag
     */
    public function getPlatformData()
    {
        $platforms = Yii::$app->getModule('gamertag')->getPlatforms();

        return isset($platforms[$this->platform]) ? $platforms[$this->platform] : null;
    }

    /**
     * Ensure that when we create a new gamertag, it's properly scoped to the user.
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            if (Yii::$app->user->isGuest) {
                return false;
            }
            $this->user_id = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
}