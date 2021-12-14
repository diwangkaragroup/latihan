<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_privilege".
 *
 * @property int $Id
 * @property string $Privilege
 * @property string $Remark
 *
 * @property User[] $users
 */
class UserPrivilege extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_privilege';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Privilege'], 'string', 'max' => 15],
            [['Remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Privilege' => 'Privilege',
            'Remark' => 'Remark',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['PrivId' => 'Id']);
    }
}
