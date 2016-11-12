<?php
namespace app\commands;

use app\models\ApacheLog;
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
     *
     * @return string
     */
    public function actionLogsInBd(){

        $content = file('/var/log/apache2/access.log');

        foreach ($content as $rec){

            //получаем айдишник последней записи
            $max_id = ApacheLog::find()
                ->select('MAX(id)')
                ->scalar();

            //в логах - служебная информация в квадратных скобках
            //дата - первая, потому используем нежадный квантификатор
            $suc1 = preg_match('/\[(.+?)\]/',$rec, $m);

            if($suc1)$exp = explode('/', $m[1]);
            else return('fault1');

            //получаем метку времени access_log
            $time = mktime(explode(':',$exp[2])[1], explode(':',$exp[2])[2], explode(':', explode(' ', $exp[2])[0])[3], $exp[1] == 'Nov' ? 9 : 1, $exp[0], explode(':',$exp[2])[0]);

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
                    $log->save();
                }
            }

            else{
                $log = new ApacheLog();
                $log->time = $time;
                $log->body = $body;
                $log->save();
            }

        }

    }
}