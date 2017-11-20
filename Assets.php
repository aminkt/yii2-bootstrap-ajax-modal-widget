<?php
namespace aminkt\widgets\ajaxBootstrapModal;


use yii\web\View;

class Assets extends \yii\web\AssetBundle
{
    public $sourcePath = __DIR__ . "/assets";
    public $css = [];

    public $js = [];

    public $jsOptions = ['position'=>View::POS_END];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}