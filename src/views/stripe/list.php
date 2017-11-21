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
                'label' => 'Amount',
                'value' => 'amount',
            ],
            [
                'label' => 'Currency',
                'value' => 'currency',
            ],
            [
                'label' => 'Status',
                'value' => 'status',
            ],
            [
                'label' => 'Type',
                'value' => function ($model) {
                    return $model->getType();
                },
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