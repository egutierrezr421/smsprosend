<?php

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/bootstrap.min.css',
        'css/fontawesome-free/css/all.min.css',
        'css/flag-icon-css/css/flag-icon.min.css',
    ];
    public $js = [
        'js/bootstrap.bundle.min.js',
        'js/jquery/dist/jquery.min.js',
    ];
    public $depends = [
    ];
}
