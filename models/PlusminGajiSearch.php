<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlusminGaji;

/**
 * PlusminGajiSearch represents the model behind the search form of `app\models\PlusminGaji`.
 */
class PlusminGajiSearch extends PlusminGaji
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_plusmin', 'kd_periode'], 'integer'],
            [['emp_id', 'tgl_plusmin', 'ket'], 'safe'],
            [['jml_plus', 'jml_min'], 'number'],
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
        $query = PlusminGaji::find();

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
            'kd_plusmin' => $this->kd_plusmin,
            'kd_periode' => $this->kd_periode,
            'tgl_plusmin' => $this->tgl_plusmin,
            'jml_plus' => $this->jml_plus,
            'jml_min' => $this->jml_min,
        ]);

        $query->andFilterWhere(['like', 'emp_id', $this->emp_id])
            ->andFilterWhere(['like', 'ket', $this->ket]);

        return $dataProvider;
    }
}
