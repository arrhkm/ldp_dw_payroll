<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bpjs;

/**
 * BpjsSearch represents the model behind the search form of `app\models\Bpjs`.
 */
class BpjsSearch extends Bpjs
{
    public $name, $reg_number;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_employee'], 'integer'],
            [['bpjs_kes', 'bpjs_tkerja', 'name', 'reg_number'], 'safe'],
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
        $query = Bpjs::find()->joinWith('employee a');

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
            'id_employee' => $this->id_employee,
        ]);

        $query->andFilterWhere(['ilike', 'bpjs_kes', $this->bpjs_kes])
            ->andFilterWhere(['ilike', 'bpjs_tkerja', $this->bpjs_tkerja])
            ->andFilterWhere(['ilike', 'a.name', $this->name])
            ->andFilterWhere(['ilike', 'a.reg_number', $this->reg_number]);

        return $dataProvider;
    }
}
