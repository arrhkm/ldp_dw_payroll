<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ComponentGroup;

/**
 * ComponentGroupSearch represents the model behind the search form of `app\models\ComponentGroup`.
 */
class ComponentGroupSearch extends ComponentGroup
{
    public $reg_number;
    public $employee_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_component_payroll', 'id_employee'], 'integer'],
            [['reg_number', 'employee_name'], 'safe']
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
        $query = ComponentGroup::find();
        $query->joinWith('employee a')->join('LEFT JOIN', 'coreperson b', 'b.id = a.id_coreperson');

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
            'id_component_payroll' => $this->id_component_payroll,
            'id_employee' => $this->id_employee,
        ]);

        $query->andFilterWhere(['ilike', 'a.reg_number',$this->reg_number]);
        $query->andFilterWhere(['ilike', 'b.name',$this->employee_name]);

        return $dataProvider;
    }
}
