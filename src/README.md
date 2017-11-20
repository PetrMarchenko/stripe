Installation
--------------------------------------------------------------------------
* Installing the package using Composer.
```
composer require marchenko/yii2-stripe
```
* Perform the migration to create the required table in the database::
```
php yii migrate --migrationPath=@shark/migrations --interactive=0
```

Examples:
--------------------------------------------------------------------------
```
1. You can create button and redefine fields:
        currency = 'usd';
        amount = 2000;
        description = 'Example charge';
        button_title = 'Pay with Card';
        key = 'pk_test_rWrMX5GKwDUzMd8zYAohdZHi';
        image = 'https://stripe.com/img/documentation/checkout/marketplace.png';
        locale = 'auto';
        name = 'Demo Site';
        window_description = '2 widgets';
        form_action = '/stripe/pay';
            
    <?=
        Stripe::widget([
            'amount' => 999
        ])
    ?>
```
```
2. You can create your controller, but use your payment method:
    public function actions()
    {
        return [
            'pay' => [
                'class' => 'shark\action\PayAction',
                'successCallback' => [
                    [
                        'callback_url' => '/example/stripe/successful',
                        'setApiKey' => Yii::$app->params['stripe']['secretKey']
                    ]
                ],
            ],
        ];
    }
    
    callback_url - it is url to your control, which we will pass after payment.
    
    /**
     * @param integer $status
     * @param \Stripe\Charge $charge
     * @return mixed
     */
    public function actionSuccessful($status = 0, $charge = null )
    {
        if ($status) {
            $messages = Yii::t('app', 'Payment complete.');
        } else {
            $messages = Yii::t('app', 'Payment failed');
        }

        return $this->render('pay', ['messages' => $messages]);
    }
            

```
