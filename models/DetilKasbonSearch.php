<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetilKasbon;

/**
 * DetilKasbonSearch represents the model behind the search form of `app\models\DetilKasbon`.
 */
class DetilKasbonSearch extends DetilKasbon
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee', 'id_kasbon'], 'integer'],
            [['nilai_cicilan'], 'number'],
            [['tgl_cicilan'], 'safe'],
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
        $query = DetilKasbon::find();

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
            'nilai_cicilan' => $this->nilai_cicilan,
            'tgl_cicilan' => $this->tgl_cicilan,
            'id_employee' => $this->id_employee,
            'id_kasbon' => $this->id_kasbon,
        ]);

        return $dataProvider;
    }
}
