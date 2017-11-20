<?php

namespace shark\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchPayment represents the model behind the search form about `shark\models\Stripe`.
 */
class SearchPayment extends Stripe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'amount',
                    'currency',
                    'status',
                    'description',
                    'updated_at',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stripe';
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Stripe::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['grid']['itemsPrePage'],
            ],
            'sort' => [
                'defaultOrder' => 'updated_at DESC',
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
