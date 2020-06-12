<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kartu;

/**
 * KartuSearch represents the model behind the search form of `app\models\Kartu`.
 */
class KartuSearch extends Kartu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_kartu', 'staff_dw'], 'integer'],
            [['emp_number_kartu', 'lokasi'], 'safe'],
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
        $query = Kartu::find();

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
            'no_kartu' => $this->no_kartu,
            'staff_dw' => $this->staff_dw,
        ]);

        $query->andFilterWhere(['like', 'emp_number_kartu', $this->emp_number_kartu])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi]);

        return $dataProvider;
    }
}
