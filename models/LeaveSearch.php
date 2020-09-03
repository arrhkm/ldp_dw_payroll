<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leave;

/**
 * LeaveSearch represents the model behind the search form of `app\models\Leave`.
 */
class LeaveSearch extends Leave
{

    public $reg_number, $employee_name, $leave_type;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee', 'id_leave_type'], 'integer'],
            [['date_leave', 'employee_name', 'reg_number', 'leave_type'], 'safe'],
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
        $query = Leave::find();
        $query->joinWith(['employee a', 'leavetype c'])->join('LEFT JOIN', 'coreperson b', 'b.id = a.id_coreperson');
        $query->orderBy(['date_leave'=>SORT_DESC]);
        //$query->joinWith('leaveType c');

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
            'date_leave' => $this->date_leave,
            'id_employee' => $this->id_employee,
            'id_leave_type' => $this->id_leave_type,
        ]);

        $query->andFilterWhere(['ilike', 'a.reg_number',$this->reg_number]);
        $query->andFilterWhere(['ilike', 'b.name', $this->employee_name]);
        $query->andFilterWhere(['ilike', 'c.name', $this->leave_type]);

        return $dataProvider;
    }
}
