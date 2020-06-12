<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Spl;

/**
 * SplSearch represents the model behind the search form of `app\models\Spl`.
 */
class SplSearch extends Spl
{
    /**
     * {@inheritdoc}
     */
    public $employee;
    public function rules()
    {
        return [
            [['id', 'overtime_value'], 'integer'],
            [['date_spl', 'start_lembur', 'end_lembur', 'so', 'nama_pekerjaan', 'employee_emp_id', 'employee'], 'safe'],
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
        $query = Spl::find();
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
            'date_spl' => $this->date_spl,
            'start_lembur' => $this->start_lembur,
            'end_lembur' => $this->end_lembur,
            'overtime_value' => $this->overtime_value,
        ]);

        $query->andFilterWhere(['like', 'so', $this->so])
            ->andFilterWhere(['like', 'nama_pekerjaan', $this->nama_pekerjaan])
            ->andFilterWhere(['like', 'employee_emp_id', $this->employee_emp_id])
            ->andFilterWhere(['like', 'employee.emp_name', $this->employee]);

        $query->orderBy(['date_spl'=>SORT_DESC]);

        return $dataProvider;
    }
}
