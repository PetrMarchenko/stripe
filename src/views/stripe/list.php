<?php

use shark\models\Stripe;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel shark\models\SearchPayment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Stripe');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stripes-index">

    <h1><?= Html::encode($this->title); ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
            ],
            [
                'attribute' => 'amount',
            ],
            [
                'attribute' => 'currency',
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '120'],
                'content' => function ($model) {
                    switch ($model->status) {
                        case Stripe::STATUS_SUCCESS:
                            $label = 'success';
                            break;
                        case Stripe::STATUS_ERROR_APP:
                        case Stripe::STATUS_ERROR_STRIPE_NOT_PAY:
                        case Stripe::STATUS_ERROR_STRIPE:
                            $label = "danger";
                            break;
                        default:
                            $label = "default";
                    }

                    $status = Stripe::getMessage($model->status);

                    return "<span class='visible-md-block visible-xs-block
                        visible-sm-block visible-lg-block label label-{$label}'>{$status}</span>";
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Stripe::allMessage()
                    ,
                    ['prompt' => Yii::t('app', 'All'), 'class' => 'form-control']
                ),
            ],
            [
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'clientOptions' => ['format' => 'yyyy-mm-d']
                ]),
                'format' => 'html',
                'content' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                },
            ],
        ],
    ]); ?>
</div>