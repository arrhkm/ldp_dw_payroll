<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Insentif;

/**
 * InsentifSearch represents the model behind the search form of `app\models\Insentif`.
 */
class InsentifSearch extends Insentif
{
    public $reg_number;
    public $employee_name;
    public $insentif;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_insentif_master', 'id_employee'], 'integer'],
            [['date_insentif', 'reg_number', 'employee_name', 'insentif'], 'safe'],
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
        $query = Insentif::find()->joinWith(['employee a', 'insentifMaster b']);
        //$query->joinWidth('insentifMaster a');


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
            'date_insentif' => $this->date_insentif,
            'id_insentif_master' => $this->id_insentif_master,
            'id_employee' => $this->id_employee,
        ]);

        $query->andFilterWhere(['ilike', 'employee.reg_number',$this->reg_number]);
        $query->andFilterWhere(['ilike', 'a.name', $this->employee_name]);
        $query->andFilterWhere(['ilike', 'b.name', $this->insentif]);
        $query->orderBy(['date_insentif'=>SORT_DESC]);
        return $dataProvider;
    }
}
