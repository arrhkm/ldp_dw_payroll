<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ChildForeman;

/**
 * ChildForemanSearch represents the model behind the search form of `app\models\ChildForeman`.
 */
class ChildForemanSearch extends ChildForeman
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'foreman_id'], 'integer'],
            [['employee_emp_id'], 'safe'],
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
        $query = ChildForeman::find();

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
            'foreman_id' => $this->foreman_id,
        ]);

        $query->andFilterWhere(['like', 'employee_emp_id', $this->employee_emp_id]);

        return $dataProvider;
    }
}
