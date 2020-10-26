<?php

namespace mdm\admin\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use appanggaran\models\BagianModels;

/**
 * BagianSearch represents the model behind the search form of `appanggaran\models\BagianModels`.
 */
class BagianSearch extends BagianModels
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IDBAGIAN', 'INDUK'], 'integer'],
            [['NAMABAGIAN', 'CODE'], 'safe'],
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
        $query = BagianModels::find();

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
            'IDBAGIAN' => $this->IDBAGIAN,
            'INDUK' => $this->INDUK,
        ]);

        $query->andFilterWhere(['like', 'NAMABAGIAN', $this->NAMABAGIAN])
            ->andFilterWhere(['like', 'CODE', $this->CODE]);

        return $dataProvider;
    }
}
