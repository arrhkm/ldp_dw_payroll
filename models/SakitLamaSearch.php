<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SakitLama;

/**
 * SakitLamaSearch represents the model behind the search form of `app\models\SakitLama`.
 */
class SakitLamaSearch extends SakitLama
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee'], 'integer'],
            [['start_sakit', 'dscription'], 'safe'],
            [['is_close'], 'boolean'],
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
        $query = SakitLama::find();

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
            'start_sakit' => $this->start_sakit,
            'is_close' => $this->is_close,
            'id_employee' => $this->id_employee,
        ]);

        $query->andFilterWhere(['ilike', 'dscription', $this->dscription]);

        return $dataProvider;
    }
}
