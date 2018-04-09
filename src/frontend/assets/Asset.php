<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\message\frontend\assets;

use yii\web\AssetBundle;

/**
 * Class Asset
 * @package yuncms\message\frontend\assets
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@yuncms/message/frontend/views/assets';


    public $js = [
        'message.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}