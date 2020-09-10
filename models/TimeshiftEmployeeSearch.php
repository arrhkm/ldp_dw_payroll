<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TimeshiftEmployee;

/**
 * TimeshiftEmployeeSearch represents the model behind the search form of `app\models\TimeshiftEmployee`.
 */
class TimeshiftEmployeeSearch extends TimeshiftEmployee
{
    public $coreperson;
    public $employee;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_period', 'id_employee', 'duration_hour'], 'integer'],
            [['date_shift', 'start_hour', 'coreperson', 'employee'], 'safe'],
            [['is_dayoff'], 'boolean'],
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
        $query = TimeshiftEmployee::find();
        $query->joinWith('employee')->join('left join', 'coreperson', 'coreperson.id = employee.id_coreperson');
        $query->orderBy(['employee.reg_number'=>SORT_ASC,'date_shift'=>SORT_ASC]);
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
            'date_shift' => $this->date_shift,
            'id_period' => $this->id_period,
            'id_employee' => $this->id_employee,
            'start_hour' => $this->start_hour,
            'duration_hour' => $this->duration_hour,
            'is_dayoff' => $this->is_dayoff,
        ]);

        $query->andFilterWhere(['ilike', 'coreperson.name', $this->coreperson]);
        $query->andFilterWhere(['ilike', 'employee.reg_number', $this->employee]);

        return $dataProvider;
    }

    public function searchByPeriod($params, $id_period)
    {
        $query = TimeshiftEmployee::find();
        $query->joinWith('employee')->join('left join', 'coreperson', 'coreperson.id = employee.id_coreperson');
        $query->orderBy(['employee.reg_number'=>SORT_ASC,'date_shift'=>SORT_ASC]);
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
            'date_shift' => $this->date_shift,
            'id_period' => $id_period,//$this->id_period,
            'id_employee' => $this->id_employee,
            'start_hour' => $this->start_hour,
            'duration_hour' => $this->duration_hour,
            'is_dayoff' => $this->is_dayoff,
        ]);

        $query->andFilterWhere(['ilike', 'coreperson.name', $this->coreperson]);
        $query->andFilterWhere(['ilike', 'employee.reg_number', $this->employee]);

        return $dataProvider;
    }
}
