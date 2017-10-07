<?php

namespace app\controllers;

use app\models\Author;
use app\models\DeutschItem;
use app\models\DeutschMark;
use app\models\DeutschTournament;
use app\models\MarkUser;
use app\models\RadioItem;
use app\models\Snapshot;
use app\models\SongText;
use app\models\Source;
use app\models\VisitBlock;
use app\models\VisitError;
use app\models\Visitor;
use app\models\VisitorCount;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class DatasController extends Controller
{
    function actionShowCurrentRadioTracksTest(){
        return '<p>'.$this->getAudioTags(strip_tags(file("http://37.192.187.83:10088/status.xsl?mount=/test_mp3")[64])).'</p>';
    }

    function actionShowCurrentRadioTracksSecond(){
        return '<p>'.$this->getAudioTags(strip_tags(file("http://37.192.187.83:10088/status.xsl?mount=/second_mp3")[64])).'</p>';
    }

    function actionShowCurrentRadioTracksBard(){
        return '<p>'.$this->getAudioTags(strip_tags(file("http://37.192.187.83:10088/status.xsl?mount=/bard_mp3")[64])).'</p>';;
    }


    /**
     * Логирование входов на сервисы
     * @throws \Exception
     */
    function actionComeIn()
    {
      //print_r(json_decode($_POST['components'])); exit;

       if(isset($_POST['hash']) && isset($_POST['components']) && isset($_POST['site']) && isset($_POST['block'])) {


           $json_string = $_POST['components'];
           $obj = json_decode($json_string);
           //var_dump($obj); exit;

           if($visitor = VisitorCount::findOne(['hash' => $_POST['hash']])){
               $visitor->count++;
               $visitor->update(false);

               $block = new VisitBlock();
               $block->visitor_id = $visitor->id;
               $block->time = time();
               $block->site = $_POST['site'];
               $block->block = $_POST['block'];


               if(isset($_POST['ip_json'])){

                   $ip_obj = json_decode($_POST['ip_json']);
                   $block->ip = $ip_obj->ip;
                   $block->hostname = $ip_obj->hostname;
                   $block->city = $ip_obj->city;
                   $block->region = $ip_obj->region;
                   $block->country = $ip_obj->country;
                   $block->loc = $ip_obj->loc;
                   $block->org = $ip_obj->org;
                   $block->postal = $ip_obj->postal;

               }
               
               if(!$block->save(false)){
                   $error = new VisitError();
                   $error->time = time();
                   $error->text = 'ошибка сохранения блока на '. $_POST['site'] . ' в блок '. $_POST['block'] . ' hash ' . $_POST['hash'];
                   $error->save(false);
               }
           }
           else{

               try {
                   $visitor = new VisitorCount();
                   $visitor->hash = $_POST['hash'];
                   $visitor->count = 0;
               } catch (ErrorException $e) {
                  
                   $error = new VisitError();
                   $error->time = time();
                   $error->text = $e->getMessage();
                   $error->save(false);
               }
               

               if($visitor->save(false)) {
                   $visit = new Visitor();

                   $visit->time = time();

                   $visit->visitor_id = $visitor->id;

                   $visit->site = $_POST['site'];
                   $visit->block = $_POST['block'];
                   

                   for ($i = 0; $i < count($obj); $i++) {
                       if ($obj[$i]->key == 'user_agent') $visit->user_agent = $obj[$i]->value;
                       if ($obj[$i]->key == 'language') $visit->language = $obj[$i]->value;
                       if ($obj[$i]->key == 'color_depth') $visit->color_depth = $obj[$i]->value;
                       if ($obj[$i]->key == 'pixel_ratio') $visit->pixel_ratio = $obj[$i]->value;
                       if ($obj[$i]->key == 'hardware_concurrency') $visit->hardware_concurrency = $obj[$i]->value;

                       if ($obj[$i]->key == 'resolution') {
                           $visit->resolution_x = $obj[$i]->value[0];
                           $visit->resolution_y = $obj[$i]->value[1];
                       }

                       if ($obj[$i]->key == 'available_resolution') {
                           $visit->available_resolution_x = $obj[$i]->value[0];
                           $visit->available_resolution_y = $obj[$i]->value[1];
                       }


                       if ($obj[$i]->key == 'timezone_offset') $visit->timezone_offset = $obj[$i]->value;
                       if ($obj[$i]->key == 'session_storage') $visit->session_storage = $obj[$i]->value;
                       if ($obj[$i]->key == 'local_storage') $visit->local_storage = $obj[$i]->value;

                       if ($obj[$i]->key == 'indexed_db') $visit->indexed_db = $obj[$i]->value;
                       if ($obj[$i]->key == 'open_database') $visit->open_database = $obj[$i]->value;
                       if ($obj[$i]->key == 'cpu_class') $visit->cpu_class = $obj[$i]->value;

                       if ($obj[$i]->key == 'navigator_platform') $visit->navigator_platform = $obj[$i]->value;
                       if ($obj[$i]->key == 'do_not_track') $visit->do_not_track = $obj[$i]->value;
                       if ($obj[$i]->key == 'regular_plugins') $visit->regular_plugins = implode('; ', $obj[$i]->value);

                       if ($obj[$i]->key == 'canvas') $visit->canvas = $obj[$i]->value;
                       if ($obj[$i]->key == 'webgl') $visit->webgl = $obj[$i]->value;
                       if ($obj[$i]->key == 'adblock') $visit->adblock = $obj[$i]->value ? 1 : 0;

                       if ($obj[$i]->key == 'has_lied_languages') $visit->has_lied_languages = $obj[$i]->value ? 1 : 0;
                       if ($obj[$i]->key == 'has_lied_resolution') $visit->has_lied_resolution = $obj[$i]->value ? 1 : 0;
                       if ($obj[$i]->key == 'has_lied_os') $visit->has_lied_os = $obj[$i]->value ? 1 : 0;

                       if ($obj[$i]->key == 'has_lied_browser') $visit->has_lied_browser = $obj[$i]->value ? 1 : 0;
                       if ($obj[$i]->key == 'touch_support') $visit->touch_support = $obj[$i]->value[0] ? 1 : 0;
                       if ($obj[$i]->key == 'js_fonts') $visit->js_fonts = implode('; ', $obj[$i]->value);

                   }

                  //var_dump($visit); exit;
                   
                   if(!$visit->save(false)) {
                       $error = new VisitError();
                       $error->time = time();
                       $error->text = 'ошибка сохранения входа на '. $_POST['site'] . ' в блок '. $_POST['block'] . ' hash ' . $_POST['hash'];
                       $error->save(false);

                   }
                   else{
                       $block = new VisitBlock();
                       $block->visitor_id = $visitor->id;
                       $block->time = time();
                       $block->site = $_POST['site'];
                       $block->block = $_POST['block'];
                       if(!$block->save(false)){
                           $error = new VisitError();
                           $error->time = time();
                           $error->text = 'ошибка сохранения блока на '. $_POST['site'] . ' в блок '. $_POST['block'] . ' hash ' . $_POST['hash'];
                           $error->save(false);
                       }
                   }
               }

               else{
                   $error = new VisitError();
                   $error->time = time();
                   $error->text = 'ошибка сохранения пользователя - hash: '. $_POST['hash'] . 'на сайте '. $_POST['site'] . ' в блок '. $_POST['block'] . ' hash ' . $_POST['hash'];
                   $error->save(false);
               }
           }
       }

        else{
            $error = new VisitError();
            $error->time = time();
            $error->text = 'Вход без данных';
            $error->save(false);
        }


    }

    /**
     * Аудио тэги из базы
     * @param $api_string
     * @return string
     */
    function getAudioTags($api_string){
        $item = RadioItem::find()->where(['like', 'audio', trim($api_string)])->one();
        //return var_dump($item);

        if($item) return $item->cat->name." :: ".$item->anons." :: ".$item->title;

        return trim($api_string);

    }

    /**
     * Отдаёт названия альбомов с автором
     * @return string
     */
    function actionAuthorsAlbums(){
        $res = [];

        $sources = Source::find()
            ->where('')
            ->all();

        foreach ($sources as $source){
            $res[] = $source->author->name .' ::: '.$source->title;
        }

        return  json_encode($res);
    }

    /**
     * Отдаёт немецкие слова
     * @return string
     */
    function actionDeutschWords(){
        $res = [];

        $words = DeutschItem::find()
            ->all();

        foreach ($words as $word){
            $res[] = $word->d_word;
        }

        return  json_encode($res);
    }

    /**
     * Отдаёт переводы немецких карточек
     * @return string
     */
    function actionTranslations(){
        $res = [];

        $words = DeutschItem::find()
            ->all();

        foreach ($words as $word){
            $res[] = $word->d_word_translation;
        }

        return  json_encode($res);
    }


    /**
     * Отдаём альбом
     * @return string
     */
    function actionGetAlbum(){

        if(isset($_POST['album'])) {
            $album = explode(':::', $_POST['album'])[1];
            //var_dump(Source::find()->where('title like "%'.trim($album).'%"')->one()); exit;

                if(Source::find()->where('title like "%'.trim($album).'%"')->one()){
                    //echo $album; exit;
                    $source_id = Source::find()->where('title like "%'.trim($album).'%"')->one()->id;
                    
                    $songs = SongText::find()->where("source_id=$source_id")->all();
                    $source = Source::findOne($source_id);

                    return $this->renderPartial('album', ['songs' => $songs, 'source' => $source]);
                    //return var_dump($items);
                }

                else echo 'uups';


            }

    }

    /**
     * Вывод карточки со словом
     * @return string
     */
    function actionGetWordCard(){
        $word = DeutschItem::find()
            ->where(['shown' => 0])
            ->orderBy(['rand()' => SORT_DESC])
            ->one();
        if($word) {
            $word->shown = 1;
            $word->update(false);
        }
        else {
            $words = DeutschItem::find()->all();
            foreach ($words as $word){
                $word->shown = 0;
                $word->update(false);
            }
            $word = DeutschItem::find()
                ->where(['shown' => 0])
                ->orderBy(['rand()' => SORT_DESC])
                ->one();
            $word->shown = 1;
            $word->update(false);
        }

       
       
        return $this->renderPartial('word', ['word' => $word]);
    }

    /**
     * Проверить перевод
     * @return string
     */
    function actionTestTranslation(){
        //return var_dump($_POST['user_id']);

        if(isset($_POST['word']) && isset($_POST['id']) && isset($_POST['user_id'])) {
            $word = $_POST['word'];
            $id = $_POST['id'];
            $user_id = (int)$_POST['user_id'];

            if($obj = DeutschItem::find()->where('d_word_translation like "'.trim($word).'"')->one()){

                if($obj->id == $id) {
                    $mark = new DeutschMark();
                    $mark->user_id = $user_id;
                    $mark->mark = 1;
                    $mark->time = time();
                    $mark->word_id = $id;
                    if($mark->save(false))
                        return '<h3>Правильно!</h3>';
                    else return 'uups база';
                }
                else {
                    $mark = new DeutschMark();
                    $mark->user_id = $user_id;
                    $mark->mark = -1;
                    $mark->time = time();
                    $mark->word_id = $id;
                    if($mark->save(false))
                        return '<h3>Не правильно!</h3>';
                    else echo 'uups база';
                }
            }

            else return  '<h3>Двигайтесь дальше!</h3>';


        }

    }

    function actionTestTranslationFail(){
        if(isset($_POST['id']) && isset($_POST['user_id'])) {
            
            $id = $_POST['id'];
            $user_id = (int)$_POST['user_id'];
            
                    $mark = new DeutschMark();
                    $mark->user_id = $user_id;
                    $mark->mark = -1;
                    $mark->time = time();
                    $mark->word_id = $id;
                    $mark->save(false);

        }
    }

    /**
     * Входит пользователь
     * @return mixed|string
     */
    public function actionLogin(){

        if(Yii::$app->getRequest()->getQueryParam('name')) {

            $name = Yii::$app->getRequest()->getQueryParam('name');
            $pseudo = Yii::$app->getRequest()->getQueryParam('pseudo');

            $user = MarkUser::find()
                ->where("name like('%" . $name . "')")
                ->one();


            if($user->id == 2) {
                return $this->renderPartial('menu', ['user' => $user]);
            }

            if($user) {

                return $user->id;
                
            }
            else return "<p>Увы, Вас нет в базе</p>";

        }

        else {
            return $this->render('index');
        }

    }

    public function actionGetMarks(){
        $today = strtotime('today');
        if(Yii::$app->getRequest()->getQueryParam('id')) {
            $user = MarkUser::findOne((int)Yii::$app->getRequest()->getQueryParam('id'));
            
            $marks = DeutschMark::find()
                ->select(['user_id, mark, COUNT(*) as cnt, SUM(mark) as avg '])
                ->where("time > $today")
                ->groupBy('user_id')
                ->orderBy(['avg' => SORT_DESC])
                ->all();
            
            $teams = DeutschTournament::find()
                ->select(['user_id, mark, COUNT(id) as cnt, SUM(mark) as avg '])
                ->groupBy('user_id')
                ->orderBy(['avg' => SORT_DESC])
                ->all();

            $sum_mish_mark = Snapshot::find()
                ->select('SUM(mish_oz)')
                ->scalar();
            
            return $this->renderPartial('teams', ['marks' => $marks, 'user' => $user, 'teams' => $teams,
                'sum_mish_mark' => ($user->id == 11) ? $sum_mish_mark : NULL]);
        }
    }

    
}