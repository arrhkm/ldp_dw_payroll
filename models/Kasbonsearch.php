<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kasbon;

/**
 * Kasbonsearch represents the model behind the search form of `app\models\Kasbon`.
 */
class Kasbonsearch extends Kasbon
{
    public $employee;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee'], 'integer'],
            [['date_kasbon', 'employee'], 'safe'],
            [['nilai_kasbon'], 'number'],
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
        $query = Kasbon::find();
        $query->joinWith('employee');
        $query->where(['kasbon.is_active'=>TRUE]);

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
            'date_kasbon' => $this->date_kasbon,
            'nilai_kasbon' => $this->nilai_kasbon,
            'is_active' => $this->is_active,
            'id_employee' => $this->id_employee,
        ]);
        $query->andFilterWhere(['ilike', 'employee.name', $this->employee]);

        return $dataProvider;
    }
    public function searchKasbonClose($params){
        $query = Kasbon::find();
        $query->joinWith('employee');
        $query->where(['kasbon.is_active'=>False]);

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
            'date_kasbon' => $this->date_kasbon,
            'nilai_kasbon' => $this->nilai_kasbon,
            'is_active' => $this->is_active,
            'id_employee' => $this->id_employee,
        ]);
        $query->andFilterWhere(['ilike', 'employee.name', $this->employee]);

        return $dataProvider;
    }
}
