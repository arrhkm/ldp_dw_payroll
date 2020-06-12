<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Absensi;

/**
 * AbsensiSearch represents the model behind the search form of `app\models\Absensi`.
 */
class AbsensiSearch extends Absensi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl', 'emp_id', 'jam_in', 'jam_out', 'ket_absen', 'status', 'loc_code'], 'safe'],
            [['timestamp_diff'], 'integer'],
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
        $query = Absensi::find();

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
            'tgl' => $this->tgl,
            'jam_in' => $this->jam_in,
            'jam_out' => $this->jam_out,
            'timestamp_diff' => $this->timestamp_diff,
        ]);

        $query->andFilterWhere(['like', 'emp_id', $this->emp_id])
            ->andFilterWhere(['like', 'ket_absen', $this->ket_absen])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'loc_code', $this->loc_code]);

        return $dataProvider;
    }
}
