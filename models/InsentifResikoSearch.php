<?php

namespace app\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InsentifResiko;

/**
 * InsentifResikoSearch represents the model behind the search form of `app\models\InsentifResiko`.
 */
class InsentifResikoSearch extends InsentifResiko
{
    /**
     * {@inheritdoc}
     */
    
    public $employee;
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['value', 'dscription', 'employee_emp_id', 'employee'], 'safe'],
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
        $query = InsentifResiko::find();
        $query->joinWith('employee');

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
        ]);

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'dscription', $this->dscription])
            ->andFilterWhere(['like', 'employee_emp_id', $this->employee_emp_id]);

        $query->andFilterWhere(['like', 'employee.emp_name', $this->employee]);

        return $dataProvider;
    }
}
