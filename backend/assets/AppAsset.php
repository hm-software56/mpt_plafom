<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'theme/css/font-awesome.css',
        'theme/css/bootstrap.css',
        'theme/css/jquery.smartmenus.bootstrap.css',
        'theme/css/jquery.simpleLens.css',
        'theme/css/slick.css',
        'theme/css/nouislider.css',
        'theme/css/theme-color/lite-blue-theme.css',
        'slider/camera.css',
        'css/slimbox2.css',
        //'theme/css/default.css',
        'theme/css/component.css',
        'overlaySlider/css/jquerysctipttop.css',
        'overlaySlider/css/slider.min.css',
        'theme/css/style.css',
        'theme/css/animate.min.css',
    ];
    public $js = [
        //'theme/js/jquery.min.js',
        'theme/js/bootstrap.js',
        'theme/js/jquery.smartmenus.js',
        'theme/js/jquery.smartmenus.bootstrap.js',
        'theme/js/jquery.simpleGallery.js',
        'theme/js/jquery.simpleLens.js',
        'theme/js/slick.js',
        'theme/js/nouislider.js',
        'theme/js/custom.js',
        'slider/jquery.mobile.customized.min.js',
        'slider/jquery.easing.1.3.js',
        'slider/camera.js',
        'js/slimbox2.js',
        'theme/js/modernizr.custom.js',
        'theme/js/cbpHorizontalMenu.min.js',
        'overlaySlider/js/jquery.scrollTo.min.js',
        'overlaySlider/js/jquery.mobile-events.js',
        'overlaySlider/js/slider.min.js',
        "theme/js/min/plugins-min.js",
        "theme/js/min/app-min.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}
