<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payroll;

/**
 * PayrollSearch represents the model behind the search form of `app\models\Payroll`.
 */
class PayrollSearch extends Payroll
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_payroll_group', 'id_period', 'no_rekening', 'id_employee', 'wt', 'pt'], 'integer'],
            [['reg_number', 'payroll_name', 'jabatan', 'employee_name'], 'safe'],
            [['tg_all', 't_msker', 'i_um', 'i_tidak_tetap', 'cicilan_kasbon', 'pot_safety', 'pengurangan', 'penambahan', 'pot_bpjs_kes'], 'number'],
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
        $query = Payroll::find();

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
            'tg_all' => $this->tg_all,
            't_msker' => $this->t_msker,
            'i_um' => $this->i_um,
            'i_tidak_tetap' => $this->i_tidak_tetap,
            'cicilan_kasbon' => $this->cicilan_kasbon,
            'pot_safety' => $this->pot_safety,
            'pengurangan' => $this->pengurangan,
            'penambahan' => $this->penambahan,
            'id_payroll_group' => $this->id_payroll_group,
            'id_period' => $this->id_period,
            'no_rekening' => $this->no_rekening,
            'id_employee' => $this->id_employee,
            'wt' => $this->wt,
            'pt' => $this->pt,
            'pot_bpjs_kes' => $this->pot_bpjs_kes,
        ]);

        $query->andFilterWhere(['ilike', 'reg_number', $this->reg_number])
            ->andFilterWhere(['ilike', 'payroll_name', $this->payroll_name])
            ->andFilterWhere(['ilike', 'jabatan', $this->jabatan])
            ->andFilterWhere(['ilike', 'employee_name', $this->employee_name]);

        return $dataProvider;
    }

    public function searchByGroup($params, $id_group, $id_period)
    {
        $query = Payroll::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize'=>1000,
            ]
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
            'tg_all' => $this->tg_all,
            't_msker' => $this->t_msker,
            'i_um' => $this->i_um,
            'i_tidak_tetap' => $this->i_tidak_tetap,
            'cicilan_kasbon' => $this->cicilan_kasbon,
            'pot_safety' => $this->pot_safety,
            'pengurangan' => $this->pengurangan,
            'penambahan' => $this->penambahan,
            //'id_payroll_group' => $this->id_payroll_group,
            'id_payroll_group' => $id_group,
            'id_period' => $id_period,
            'no_rekening' => $this->no_rekening,
            'id_employee' => $this->id_employee,
            'wt' => $this->wt,
            'pt' => $this->pt,
            'pot_bpjs_kes' => $this->pot_bpjs_kes,
        ]);

        $query->andFilterWhere(['ilike', 'reg_number', $this->reg_number])
            ->andFilterWhere(['ilike', 'payroll_name', $this->payroll_name])
            ->andFilterWhere(['ilike', 'jabatan', $this->jabatan])
            ->andFilterWhere(['ilike', 'employee_name', $this->employee_name]);

        return $dataProvider;
    }
}
