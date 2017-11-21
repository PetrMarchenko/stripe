<?php

namespace shark\controllers;

use Yii;
use yii\web\Controller;
use shark\StripeAsset;
use shark\models\SearchPayment;
use shark\models\Stripe as StripeModel;


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


    /**
     * @param integer $status
     * @return mixed
     */
    public function actionSuccessful($status = 0)
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

        return $this->render('pay', ['messages' => $messages]);
    }
}
