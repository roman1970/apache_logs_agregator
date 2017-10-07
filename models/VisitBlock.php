<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visit_block".
 *
 * @property integer $id
 * @property integer $time
 * @property integer $visitor_id
 * @property string $site
 * @property string $block
 *
 * @property VisitorCount $visitor
 */
class VisitBlock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'visitor_id', 'site', 'block'], 'required'],
            [['time', 'visitor_id'], 'integer'],
            [['site', 'block'], 'string', 'max' => 255],
            [['visitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => VisitorCount::className(), 'targetAttribute' => ['visitor_id' => 'id']],
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
            'visitor_id' => 'Visitor ID',
            'site' => 'Site',
            'block' => 'Block',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisitor()
    {
        return $this->hasOne(VisitorCount::className(), ['id' => 'visitor_id']);
    }
}
