<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PayrollGroupEmployee;

/**
 * PayrollGroupEmployeeSearch represents the model behind the search form of `app\models\PayrollGroupEmployee`.
 */
class PayrollGroupEmployeeSearch extends PayrollGroupEmployee
{
    public $employee;
    public $group;

    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee', 'id_payroll_group'], 'integer'],
            [['employee', 'group'], 'safe'],
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
        $query = PayrollGroupEmployee::find()
        ->joinWith('employee a')
        ->join('JOIN', 'payroll_group b', 'b.id= id_payroll_group')
        ;

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
            'id_payroll_group' => $this->id_payroll_group,
        ]);

        $query->andFilterWhere(['ilike', 'a.name', $this->employee])
            ->andFilterWhere( ['ilike', 'b.name', $this->group]);

        return $dataProvider;
    }
}
