<?php

namespace mdm\admin\models\searchs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserActHistory;

/**
 * UserActHistorySearch represents the model behind the search form of `common\models\UserActHistory`.
 */
class UserActHistorySearch extends UserActHistory
{
    public $tanggal_awal;
    public $tanggal_akhir;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user'], 'integer'],
            [['username', 'nama', 'url', 'modul', 'keterangan', 'tanggal', 'tanggal_awal', 'tanggal_akhir'], 'safe'],
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
        $query = UserActHistory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if($this->tanggal != ""){
            // Explode kedua tanggal
            $tanggal = explode(' - ', $this->tanggal);

            // Masukan awal dan akhir
            $this->tanggal_awal = $tanggal[0];
            $this->tanggal_akhir = $tanggal[1];
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
            'act' => $this->act
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            // Between
            ->andFilterWhere(['between', 'tanggal', $this->tanggal_awal, $this->tanggal_akhir])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'modul', $this->modul])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
