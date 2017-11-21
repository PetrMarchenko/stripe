<?php
namespace shark\models;

use Yii;
use yii\db\ActiveRecord;
use shark\models\forms\StripeForm;
use Stripe\Charge;
use Stripe\Refund;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "stripe".
 *
 * @property integer $id
 * @property string $currency
 * @property string $updated_at
 * @property string $status
 * @property integer $amount
 * @property integer $stripe_id
 * @property integer $type
 */
class Stripe extends ActiveRecord
{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR_APP = 0;
    const STATUS_ERROR_STRIPE = -1;
    const STATUS_ERROR_STRIPE_NOT_PAY = -2;
    const STATUS_ERROR_STRIPE_NOT_REFUND = -3;

    const TYPE_REFUND = 2;
    const TYPE_PAY = 1;

    protected static $title_type = [
        Stripe::TYPE_REFUND => 'REFUND',
        Stripe::TYPE_PAY => 'PAY',
    ];

    public function getType()
    {
        return isset(self::$title_type[$this->type]) ? self::$title_type[$this->type] : '';
    }

    public function rules()
    {
        return [
            [['amount', 'stripe_id', 'currency', 'status',  'type'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * Find page by id
     *
     * @param $id
     * @return $this|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
}