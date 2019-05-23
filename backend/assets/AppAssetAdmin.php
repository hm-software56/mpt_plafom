<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAssetAdmin extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'admin-theme/assets/css/bootstrap.min.css',
        'admin-theme/assets/css/material-dashboard.css',
        'admin-theme/assets/css/demo.css',
        'css/visiter.css',
        
    ];
    public $js = [
        //"admin-theme/assets/js/bootstrap.min.js",
        "admin-theme/assets/js/material.min.js",
        // "admin-theme/assets/js/bootstrap-notify.js",
        "admin-theme/assets/js/material-dashboard.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
