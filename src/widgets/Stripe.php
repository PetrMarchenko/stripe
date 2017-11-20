<?php
namespace shark\widgets;

use Yii;
use yii\base\Widget;
use shark\StripeAsset;


class Stripe extends Widget
{
    public $currency = 'usd';
    public $amount = 2000;
    public $description = 'Example charge';
    public $button_title = 'Pay with Card';
    public $key = 'pk_test_rWrMX5GKwDUzMd8zYAohdZHi';
    public $image = 'https://stripe.com/img/documentation/checkout/marketplace.png';
    public $locale = 'auto';
    public $name = 'Demo Site';
    public $window_description = '2 widgets';
    public $form_action = '/stripe/pay';


    public function init()
    {
        $view = Yii::$app->getView();
        StripeAsset::register($view);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        return $this->render('index', ['widget' => $this]);
    }
}