<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tunjangan;

/**
 * TunjanganSearch represents the model behind the search form of `app\models\Tunjangan`.
 */
class TunjanganSearch extends Tunjangan
{
    /**
     * {@inheritdoc}
     */
    public $employee;
    public function rules()
    {
        return [
            [['id', 'jenis_tunjangan_id'], 'integer'],
            [['tanggal', 'employee_emp_id',  'employee'], 'safe'],
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
        $query = Tunjangan::find();
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
            'tanggal' => $this->tanggal,
            'jenis_tunjangan_id' => $this->jenis_tunjangan_id,
        ]);

        $query->andFilterWhere(['like', 'employee_emp_id', $this->employee_emp_id])
            ->andFilterWhere(['like', 'employee.emp_name', $this->employee]);


        return $dataProvider;
    }
}
