<?php

namespace mirkhamidov\alert\assets;


use yii\web\AssetBundle;

class AlertAssets extends AssetBundle
{
    public $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'alert';

    public $js = [
        'js/js.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}