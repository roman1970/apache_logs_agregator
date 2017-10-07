<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitor_count".
 *
 * @property integer $id
 * @property string $hash
 * @property integer $count
 *
 * @property Visitor[] $visitors
 */
class VisitorCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visitor_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hash'], 'required'],
            [['count'], 'integer'],
            [['hash'], 'string', 'max' => 255],
            [['hash'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitors()
    {
        return $this->hasMany(Visitor::className(), ['visitor_id' => 'id']);
    }
}
