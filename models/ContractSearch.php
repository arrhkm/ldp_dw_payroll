<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contract;

/**
 * ContractSearch represents the model behind the search form of `app\models\Contract`.
 */
class ContractSearch extends Contract
{
    public $employee_name;
    public $employee_reg_number;
    public $contract_type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'duration_contract', 'id_contract_type', 'id_employee', 'id_department', 'id_job_alocation', 'id_jobtitle', 'id_jobrole', 'id_division'], 'integer'],
            [['start_contract', 'number_contract', 'doh', 'employee_name', 'contract_type', 'employee_reg_number'], 'safe'],
            [['basic_salary'], 'number'],
            [['is_active'], 'boolean'],
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
        $query = Contract::find();
        $query->joinWith('employee a');
        $query->joinWith('contractType b');
        //$query->where(['contract.is_active'=>true]);

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
            'start_contract' => $this->start_contract,
            'duration_contract' => $this->duration_contract,
            'id_contract_type' => $this->id_contract_type,
            'id_employee' => $this->id_employee,
            'id_department' => $this->id_department,
            'id_job_alocation' => $this->id_job_alocation,
            'id_jobtitle' => $this->id_jobtitle,
            'id_jobrole' => $this->id_jobrole,
            'id_division' => $this->id_division,
            'basic_salary' => $this->basic_salary,
            'doh' => $this->doh,
            'contract.is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['ilike', 'number_contract', $this->number_contract]);
        $query->andFilterWhere(['ilike', 'a.name', $this->employee_name]);
        $query->andFilterWhere(['ilike', 'a.reg_number', $this->employee_reg_number]);
        $query->andFilterWhere(['b.name_contract'=>$this->contract_type]);


        return $dataProvider;
    }
}
