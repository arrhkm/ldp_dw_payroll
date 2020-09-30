<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdjustmentSalary;

/**
 * AdjustmentSalarySearch represents the model behind the search form of `app\models\AdjustmentSalary`.
 */
class AdjustmentSalarySearch extends AdjustmentSalary
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee'], 'integer'],
            [['date_adjustment', 'code_adjustment', 'description'], 'safe'],
            [['value_adjustment'], 'number'],
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
        $query = AdjustmentSalary::find();

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
            'date_adjustment' => $this->date_adjustment,
            'value_adjustment' => $this->value_adjustment,
            'id_employee' => $this->id_employee,
        ]);

        $query->andFilterWhere(['ilike', 'code_adjustment', $this->code_adjustment])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
    public function searchByDate($params, $start_date, $end_date)
    {
        $query = AdjustmentSalary::find();
        $query->where(['BETWEEN', 'date_adjustment', $start_date, $end_date]);

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
            'date_adjustment' => $this->date_adjustment,
            'value_adjustment' => $this->value_adjustment,
            'id_employee' => $this->id_employee,
        ]);

        $query->andFilterWhere(['ilike', 'code_adjustment', $this->code_adjustment])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
