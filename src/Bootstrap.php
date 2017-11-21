<?php
namespace shark;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            'stripe/view' => 'stripe/stripe/index',
            'stripe/pay' => 'stripe/stripe/pay',
            'stripe/successful' => '/stripe/stripe/successful',
            'stripe/list' => '/stripe/stripe/list',
            'stripe/refund' => '/stripe/stripe/refund',
        ], false);

        $app->setModule('stripe', 'shark\Module');
    }
}