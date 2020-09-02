<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DailyComponentDetil;

/**
 * DailyComponentDetilSearch represents the model behind the search form of `app\models\DailyComponentDetil`.
 */
class DailyComponentDetilSearch extends DailyComponentDetil
{
    public $reg_number, $employee_name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee', 'id_daily_component'], 'integer'],
            [['date_component', 'reg_number', 'employee_name'], 'safe'],
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
        $query = DailyComponentDetil::find();

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
            'date_component' => $this->date_component,
            'id_employee' => $this->id_employee,
            'id_daily_component' => $this->id_daily_component,
        ]);

        return $dataProvider;
    }

    public function searchByComponent($params, $id_daily_component)
    {
        $query = DailyComponentDetil::find();
        $query->joinWith('employee a');
        $query->where(['id_daily_component'=>$id_daily_component]);

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
            'date_component' => $this->date_component,
            'id_employee' => $this->id_employee,
            'id_daily_component' => $this->id_daily_component,
        ]);
        $query->andFilterWhere(['ilike', 'a.reg_number', $this->reg_number]);
        $query->andFilterWhere(['ilike', 'a.name', $this->employee_name]);
        $query->orderBy('date_component desc');

        return $dataProvider;
    }
}
