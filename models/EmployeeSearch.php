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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'emp_name', 'no_rekening', 'start_work', 'start_contract', 'end_contract', 'emp_group'], 'safe'],
            [['kd_jabatan', 'lama_contract'], 'integer'],
            [['gaji_pokok', 'gaji_lembur', 'pot_jamsos', 't_jabatan', 't_masakerja', 't_insentif', 'pot_telat', 'uang_makan'], 'number'],
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
            'kd_jabatan' => $this->kd_jabatan,
            'gaji_pokok' => $this->gaji_pokok,
            'gaji_lembur' => $this->gaji_lembur,
            'pot_jamsos' => $this->pot_jamsos,
            't_jabatan' => $this->t_jabatan,
            't_masakerja' => $this->t_masakerja,
            't_insentif' => $this->t_insentif,
            'pot_telat' => $this->pot_telat,
            'uang_makan' => $this->uang_makan,
            'start_work' => $this->start_work,
            'start_contract' => $this->start_contract,
            'end_contract' => $this->end_contract,
            'lama_contract' => $this->lama_contract,
        ]);

        $query->andFilterWhere(['like', 'emp_id', $this->emp_id])
            ->andFilterWhere(['like', 'emp_name', $this->emp_name])
            ->andFilterWhere(['like', 'no_rekening', $this->no_rekening])
            ->andFilterWhere(['like', 'emp_group', $this->emp_group]);

        return $dataProvider;
    }
}
