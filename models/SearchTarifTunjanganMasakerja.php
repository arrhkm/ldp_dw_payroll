<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TarifTunjanganMasakerja;

/**
 * SearchTarifTunjanganMasakerja represents the model behind the search form of `app\models\TarifTunjanganMasakerja`.
 */
class SearchTarifTunjanganMasakerja extends TarifTunjanganMasakerja
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'masa_kerja'], 'integer'],
            [['nilai_tunjangan'], 'number'],
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
        $query = TarifTunjanganMasakerja::find();

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
            'masa_kerja' => $this->masa_kerja,
            'nilai_tunjangan' => $this->nilai_tunjangan,
        ]);

        return $dataProvider;
    }
}
