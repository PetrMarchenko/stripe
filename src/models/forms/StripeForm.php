<?php

namespace shark\models\forms;

use yii\base\Model;


/**
 * StripeForm is the model behind the update stripe.
 *
 * @property int $amount
 * @property string $currency
 * @property string $description
 * @property string $source
 * @property int $user_id
 *
 * @package Shark\forms
 */
class StripeForm extends Model
{

    public $amount;
    public $currency;
    public $description;
    public $source;
    public $user_id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['amount', 'source'], 'required'],
            [['currency', 'description'], 'string'],
        ];
    }
}
