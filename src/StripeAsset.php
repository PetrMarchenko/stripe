<?php

namespace shark;

use yii\web\AssetBundle;

/**
 */
class StripeAsset extends AssetBundle
{

    public $sourcePath = '@vendor/marchenko/yii2-stripe/assets';

    public $js = [
        'js/stripe.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
