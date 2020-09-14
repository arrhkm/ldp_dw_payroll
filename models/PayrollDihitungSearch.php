<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PayrollDihitung;

/**
 * PayrollDihitungSearch represents the model behind the search form of `app\models\PayrollDihitung`.
 */
class PayrollDihitungSearch extends PayrollDihitung
{
    public $reg_number,$employee_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee'], 'integer'],
            [['employee_name', 'reg_number'], 'safe'],
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
        $query = PayrollDihitung::find();
        $query->joinWith('employee a');

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
            'id_employee' => $this->id_employee,
        ]);
        $query->andFilterWhere(['ilike', 'a.name', $this->employee_name]);
        $query->andFilterWhere(['ilike', 'a.reg_number', $this->reg_number]);

        return $dataProvider;
    }
}
