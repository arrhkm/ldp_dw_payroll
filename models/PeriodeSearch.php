<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Periode;

/**
 * PeriodeSearch represents the model behind the search form of `app\models\Periode`.
 */
class PeriodeSearch extends Periode
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_periode', 'potongan_jamsos'], 'integer'],
            [['nama_periode', 'tgl_awal', 'tgl_akhir'], 'safe'],
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
        $query = Periode::find();

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
            'kd_periode' => $this->kd_periode,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir,
            'potongan_jamsos' => $this->potongan_jamsos,
        ]);

        $query->andFilterWhere(['like', 'nama_periode', $this->nama_periode]);

        return $dataProvider;
    }
}
