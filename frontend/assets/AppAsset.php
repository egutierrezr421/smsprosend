<?php

namespace frontend\assets;

use yii\web\AssetBundle;

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
        'plugins/toastr/toastr.min.css',
    ];
    public $js = [
        'js/bootstrap.bundle.min.js',
        'js/jquery/dist/jquery.min.js',
        'plugins/toastr/toastr.min.js',
    ];
    public $depends = [
    ];
}
