<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Coreperson;

/**
 * CorepersonSearch represents the model behind the search form of `app\models\Coreperson`.
 */
class CorepersonSearch extends Coreperson
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [
                [
                    'name', 'birth_date', 'birth_city', 'id_card', 'phone', 'address', 'bank_account', 
                    'marital_status', 'status', 'tax_account', 'city', 'bank_name'
                ], 
                'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Coreperson::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'birth_date' => $this->birth_date,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'birth_city', $this->birth_city])
            ->andFilterWhere(['ilike', 'id_card', $this->id_card])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'bank_account', $this->bank_account])
            ->andFilterWhere(['ilike', 'marital_status', $this->marital_status])
            ->andFilterWhere(['ilike', 'status', $this->status])
            ->andFilterWhere(['ilike', 'tax_account', $this->tax_account])
            ->andFilterWhere(['ilike', 'city', $this->city])
            ->andFilterWhere(['ilike', 'bank_name', $this->bank_name]);

        return $dataProvider;
    }
}
