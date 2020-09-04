<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Spkl;

/**
 * SpklSeach represents the model behind the search form of `app\models\Spkl`.
 */
class SpklSeach extends Spkl
{
    /**
     * {@inheritdoc}
     */
    public $employee;
    public $person;
    public function rules()
    {
        return [
            [['id', 'overtime_hour', 'id_employee'], 'integer'],
            [['date_spkl', 'employee'], 'safe'],
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
        $query = Spkl::find();
        $query->joinWith('employee a');

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
            'date_spkl' => $this->date_spkl,
            'overtime_hour' => $this->overtime_hour,
            'id_employee' => $this->id_employee,
        ]);
        $query->andFilterWhere(['ilike', 'a.name', $this->employee]);
        $query->orderBy(['date_spkl'=>SORT_DESC]);
        return $dataProvider;
    }
}
