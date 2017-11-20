<?php

namespace shark\controllers;

use Yii;
use yii\web\Controller;
use shark\StripeAsset;
use shark\models\SearchPayment;


/**
 * StripeController
 */
class StripeController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {

        StripeAsset::register($this->view);
        return $this->render('index');
    }

    /**
     * Lists all Payments models.
     *
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new SearchPayment();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


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
        ];
    }


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
}
