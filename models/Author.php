<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "authors".
 *
 *
 */

class Author extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db_plis');
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'name' => 'Name',

        ];
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}