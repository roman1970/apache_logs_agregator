<?php

namespace app\controllers;

use app\models\ApacheLog;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;


class LogsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Вход в меню
     * @return string|\yii\web\Response
     */
    public function actionMenu()
    {
        if (Yii::$app->user->isGuest)
        {
            return $this->redirect(Url::toRoute('site/index'));
        }

        return $this->render('menu');
    }
    /**
     * Показать последние логи
     * @return string
     */
    function actionShowLast(){
        $logs = ApacheLog::find()
            ->orderBy('id DESC')
            ->limit(10)
            ->all();
        
        return $this->renderPartial('logs', ['logs' => $logs]);
    }

    /**
     * Выборка логов по дате
     * @return string
     */
    function actionShowDate(){

        if(Yii::$app->getRequest()->getQueryParam('from') && Yii::$app->getRequest()->getQueryParam('to') ) {
           //return $this->dateToTime(Yii::$app->getRequest()->getQueryParam('from'));

            $logs = ApacheLog::find()
                ->where("time > ".$this->dateToTime(Yii::$app->getRequest()->getQueryParam('from'))
                ." AND time < ".$this->dateToTime(Yii::$app->getRequest()->getQueryParam('to')))
                ->orderBy('id DESC')
                ->all();

            if($logs)
                return $this->renderPartial('logs', ['logs' => $logs]);
            else return("Логов за выбранный период нет... <br>Соблюдайте формат вводимых данных!");
        }
        else
            return $this->renderPartial('date_interval');
    }


    /**
     * Костыльный метод, который преобразует дату в формате 'Y-m-d' в метку
     * @param $date
     * @return int
     */
    function dateToTime($date){
        $arr_date = explode('-',$date);
        return mktime(0, 0, 0, $arr_date[1], $arr_date[2], $arr_date[0]);
    }
    
    function actionApi(){
        //return 'gg';
        if(Yii::$app->getRequest()->getQueryParam('key') == 'e4') {
            if (Yii::$app->getRequest()->getQueryParam('limit')) {
                $logs = ApacheLog::find()
                    ->orderBy('id DESC')
                    ->limit((int)Yii::$app->getRequest()->getQueryParam('limit'))
                    ->all();
                if ($logs) {
                    $arr = null;
                    foreach ($logs as $log) {
                        $arr[$log->id]['id'] = $log->id;
                        $arr[$log->id]['time'] = $log->time;
                        $arr[$log->id]['body'] = $log->body;
                    }
                    return json_encode($arr);
                }
            }
            if (Yii::$app->getRequest()->getQueryParam('from') && Yii::$app->getRequest()->getQueryParam('to')) {
                $logs = ApacheLog::find()
                    ->where("time > " . $this->dateToTime(Yii::$app->getRequest()->getQueryParam('from'))
                        . " AND time < " . $this->dateToTime(Yii::$app->getRequest()->getQueryParam('to')))
                    ->orderBy('id DESC')
                    ->all();
                
                if ($logs){
                    $arr = [];
                    foreach ($logs as $log){
                        $arr[]['id'] = $log->id;
                        $arr[]['time'] = $log->time;
                        $arr[]['body'] = $log->body;
                    }
                    return json_encode($arr);
                }

                else return $this->renderPartial('json_error');
            }
        }

        return $this->renderPartial('json_error');
    }

    function actionApiPermission(){
        return 'Чтобы получать данные введите в адресной строке браузера <br>
                <pre>'.Url::home(true).'logs/api/?from=2016-11-13&to=2016-11-14&key=e4</pre>'.',
                где параметр from - начальная дата желаемого интервала, to - конечная, key - ваш ключ<br>
                Чтобы получить последние 50 логов, нужно ввести такую строку <br>
                <pre>'.Url::home(true).'logs/api/?limit=50&key=e4</pre>';
    }

}