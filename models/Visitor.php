<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visitor".
 *
 * @property integer $id
 * @property integer $time
 * @property string $hash
 * @property string $site
 * @property string $block
 * @property string $user_agent
 * @property string $language
 * @property integer $color_depth
 * @property integer $pixel_ratio
 * @property integer $hardware_concurrency
 * @property integer $resolution_x
 * @property integer $resolution_y
 * @property integer $available_resolution_x
 * @property integer $available_resolution_y
 * @property integer $timezone_offset
 * @property integer $session_storage
 * @property integer $local_storage
 * @property integer $indexed_db
 * @property integer $open_database
 * @property string $cpu_class
 * @property string $navigator_platform
 * @property string $do_not_track
 * @property string $regular_plugins
 * @property string $canvas
 * @property string $webgl
 * @property integer $adblock
 * @property integer $has_lied_languages
 * @property integer $has_lied_resolution
 * @property integer $has_lied_os
 * @property integer $has_lied_browser
 * @property string $touch_support
 * @property string $js_fonts
 */
class Visitor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visitor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'hash', 'site', 'block', 'user_agent', 'language', 'cpu_class', 'navigator_platform', 'do_not_track', 'canvas', 'webgl', 'touch_support', 'js_fonts'], 'required'],
            [['time', 'color_depth', 'pixel_ratio', 'hardware_concurrency', 'resolution_x', 'resolution_y', 'available_resolution_x', 'available_resolution_y', 'timezone_offset', 'session_storage', 'local_storage', 'indexed_db', 'open_database', 'adblock', 'has_lied_languages', 'has_lied_resolution', 'has_lied_os', 'has_lied_browser'], 'integer'],
            [['regular_plugins'], 'string'],
            [['hash', 'site', 'block', 'user_agent', 'language', 'cpu_class', 'navigator_platform', 'do_not_track', 'canvas', 'webgl', 'touch_support', 'js_fonts'], 'string', 'max' => 255],
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
            'hash' => 'Hash',
            'site' => 'Site',
            'block' => 'Block',
            'user_agent' => 'User Agent',
            'language' => 'Language',
            'color_depth' => 'Color Depth',
            'pixel_ratio' => 'Pixel Ratio',
            'hardware_concurrency' => 'Hardware Concurrency',
            'resolution_x' => 'Resolution X',
            'resolution_y' => 'Resolution Y',
            'available_resolution_x' => 'Available Resolution X',
            'available_resolution_y' => 'Available Resolution Y',
            'timezone_offset' => 'Timezone Offset',
            'session_storage' => 'Session Storage',
            'local_storage' => 'Local Storage',
            'indexed_db' => 'Indexed Db',
            'open_database' => 'Open Database',
            'cpu_class' => 'Cpu Class',
            'navigator_platform' => 'Navigator Platform',
            'do_not_track' => 'Do Not Track',
            'regular_plugins' => 'Regular Plugins',
            'canvas' => 'Canvas',
            'webgl' => 'Webgl',
            'adblock' => 'Adblock',
            'has_lied_languages' => 'Has Lied Languages',
            'has_lied_resolution' => 'Has Lied Resolution',
            'has_lied_os' => 'Has Lied Os',
            'has_lied_browser' => 'Has Lied Browser',
            'touch_support' => 'Touch Support',
            'js_fonts' => 'Js Fonts',
        ];
    }
}
