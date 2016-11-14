<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class ApacheLogSearch extends ApacheLog
{
    public function rules()
    {
        return [

            [['time, body, ip'], 'save'],
        ];
    }


    public function search($params)
    {
        $query = ApacheLog::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}