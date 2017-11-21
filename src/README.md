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
1. You can create button.
```
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

2. You can create your controller

```
2.1 Use payment or refund method:
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'pay' => [
                'class' => 'shark\action\PayAction',
                'successCallback' => [
                    [
                        'callback_url' => 'stripe/successful',
                        'setApiKey' => Yii::$app->params['stripe']['secretKey']
                    ]
                ],
            ],
            'refund' => [
                'class' => 'shark\action\RefundAction',
                'successCallback' => [
                    [
                        'callback_url' => 'stripe/successful',
                        'setApiKey' => Yii::$app->params['stripe']['secretKey']
                    ]
                ],
            ],
        ];
    }
    
    callback_url - it is url to your control, which we will pass after payment.
    
    /**
     * @param integer $status
     * @param integer $id
     * @return mixed
     */
    public function actionSuccessful($status = 0, $id = 0)
    {
        $messages = 'Please, try again later';

        switch ($status) {
            case StripeModel::STATUS_SUCCESS:
                $messages = 'Payment complete.';
                break;
            case StripeModel::STATUS_ERROR_STRIPE_NOT_PAY:
            case StripeModel::STATUS_ERROR_STRIPE_NOT_REFUND:
            case StripeModel::STATUS_ERROR_APP:
            case StripeModel::STATUS_ERROR_STRIPE:
                $messages = 'Payment failed';
                break;
        }

        return $this->render('successful',
            [
                'messages' => $messages,
                'stripeModel' => $stripeModel = StripeModel::findById($id)
            ]
        );
    }            
```
