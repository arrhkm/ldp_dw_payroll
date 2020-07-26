<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form of `app\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    public $person_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_jobtitle', 'id_division', 'id_jobrole', 'id_department', 'id_coreperson', 'id_location', 'id_job_alocation'], 'integer'],
            [['reg_number', 'no_bpjstk', 'no_bpjskes', 'date_of_hired', 'type', 'email', 'name', 'person_name'], 'safe'],
            [['is_permanent', 'is_active'], 'boolean'],
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
        $query = Employee::find();
        $query->joinWith('coreperson');

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
            'employee.id' => $this->id,
            'date_of_hired' => $this->date_of_hired,
            'is_permanent' => $this->is_permanent,
            'id_jobtitle' => $this->id_jobtitle,
            'id_division' => $this->id_division,
            'id_jobrole' => $this->id_jobrole,
            'id_department' => $this->id_department,
            'id_coreperson' => $this->id_coreperson,
            'id_location' => $this->id_location,
            'is_active' => $this->is_active,
            'id_job_alocation' => $this->id_job_alocation,
        ]);

        $query->andFilterWhere(['ilike', 'reg_number', $this->reg_number])
            ->andFilterWhere(['ilike', 'no_bpjstk', $this->no_bpjstk])
            ->andFilterWhere(['ilike', 'no_bpjskes', $this->no_bpjskes])
            ->andFilterWhere(['ilike', 'type', $this->type])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'coreperson.name', $this->person_name])
            ->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
    }
}
