<?php
namespace app\commands;

use app\models\ApacheLog;
use Yii;
use yii\console\Controller;

class ApacheLogsController extends Controller
{
    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }


    /**
     * Экшн для запуска по крону для сбора логов базу 
     * @return string
     */
    public function actionLogsInBd(){


        $content = file(Yii::$app->params['log_file']);

        foreach ($content as $rec){

            //получаем айдишник последней записи
            $max_id = ApacheLog::find()
                ->select('MAX(id)')
                ->scalar();

            $ip = '';
            
            $ip_succ = preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/', $rec, $ips_arr);

            if($ip_succ) $ip = $ips_arr[0];
            else return('fault0');

            if($ip == '192.168.1.1' || $ip == '127.0.0.1' ) continue;

            //var_dump($ips_arr); exit;

            //в логах - служебная информация в квадратных скобках
            //дата - первая, потому используем нежадный квантификатор
            $suc1 = preg_match('/\[(.+?)\]/', $rec, $m);

            if($suc1) $exp = explode('/', $m[1]);
            else return('fault1');

            $month = 0;
            //exit;
            
            switch ($exp[1]) {
                case 'Jan' :
                    $month = 1;
                    break;
                case 'Feb' :
                    $month = 2;
                    break;
                case 'Mar' :
                    $month = 3;
                    break;
                case 'Apr' :
                    $month = 4;
                    break;
                case 'May' :
                    $month = 5;
                    break;
                case 'Jun' :
                    $month = 6;
                    break;
                case 'Jul' :
                    $month = 7;
                    break;
                case 'Aug' :
                    $month = 8;
                    break;
                case 'Sep' :
                    $month = 9;
                    break;
                case 'Oct' :
                    $month = 10;
                    break;
                case 'Nov' :
                    $month = 11;
                    break;
                case 'Dec' :
                    $month = 12;
                    break;
                default :
                    $month = 0;
            }
            

            //получаем метку времени access_log, на месяц стоит заглушка
            $time = mktime(explode(':',$exp[2])[1], explode(':',$exp[2])[2], explode(':', explode(' ', $exp[2])[0])[3], $month, $exp[0], explode(':',$exp[2])[0]);

            //получаем тело лога
            $suc2 = preg_match('/\](.+)/',$rec, $bod);
            if($suc2)  $body = $bod[1];
            else return('fault2');

            //если есть хоть одна запись в таблице
            if(ApacheLog::findOne($max_id)) {
                //пишем только новые логи
                if ($time > ApacheLog::findOne($max_id)->time) {
                    $log = new ApacheLog();
                    $log->time = $time;
                    $log->body = $body;
                    $log->ip = $ip;
                    $log->save();
                }
            }

            else{
                $log = new ApacheLog();
                $log->time = $time;
                $log->body = $body;
                $log->ip = $ip;
                $log->save();
            }
            

        }

    }
}