<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apache_logs".
 *
 * @property integer $id
 * @property integer $time
 * @property string $body
 */
class ApacheLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apache_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'body'], 'required'],
            [['time'], 'integer'],
            [['body'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'body' => 'Body',
        ];
    }
}
