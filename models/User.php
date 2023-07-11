<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class User extends \yii\db\ActiveRecord
{

    public $ID;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'address'], 'required'],
            [['address'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['username'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public static function findActiveUser()
    {
        return self::findAll(['flag_active' => 1]);
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }
}
