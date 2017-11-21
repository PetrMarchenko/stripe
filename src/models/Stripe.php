<?php
namespace shark\models;

use Yii;
use yii\db\ActiveRecord;
use shark\models\forms\StripeForm;
use Stripe\Charge;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "stripe".
 *
 * @property integer $id
 * @property string $currency
 * @property string $description
 * @property string $source
 * @property string $updated_at
 * @property integer $amount
 * @property integer $user_id
 * @property integer $status
 * @property integer $stripe_id
 */
class Stripe extends ActiveRecord
{
    const STATUS_ERROR_STRIPE = -1;
    const STATUS_ERROR_STRIPE_NOT_PAY = -2;
    const STATUS_ERROR_STRIPE_NOT_REFUND = -3;
    const STATUS_ERROR_APP = 0;
    const STATUS_SUCCESS = 1;

    protected static $message = [
        Stripe::STATUS_SUCCESS => 'Done',
        Stripe::STATUS_ERROR_STRIPE_NOT_PAY => 'Not pay',
        Stripe::STATUS_ERROR_APP => 'App error',
        Stripe::STATUS_ERROR_STRIPE => 'Stripe error'
    ];

    public static function getMessage($key)
    {

        return isset(self::$message[$key]) ? self::$message[$key] : '';
    }

    public static function allMessage()
    {

        return self::$message;
    }

    public function rules()
    {
        return [
            [['amount', 'source', 'description', 'stripe_id'], 'required'],
            [['currency', 'description'], 'string'],
            [['user_id'], 'integer'],
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

    public function log(StripeForm $stripeForm, Charge $charge)
    {
        $this->currency = $stripeForm->currency;
        $this->description = $stripeForm->description;
        $this->source = $stripeForm->source;
        $this->amount = $stripeForm->amount;
        $this->user_id = $stripeForm->user_id;
        $this->status = ($charge->paid) ? Stripe::STATUS_SUCCESS : Stripe::STATUS_ERROR_STRIPE_NOT_PAY;
        $this->stripe_id = $charge->id;
        $this->save();
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