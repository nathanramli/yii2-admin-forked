<?php

namespace mdm\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OfficeOrUnit;


/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class User extends Model
{
    public $id;
    public $username;
    public $email;
    public $id_bagian;
    public $id_kelompok;
    public $id_cabang;
    public $nama;
    public $status;
    public $id_bidang;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'nama', 'id_cabang', 'id_bidang'], 'safe'],
        ];
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
        /* @var $query \yii\db\ActiveQuery */
        $class = Yii::$app->getUser()->identityClass ?: 'mdm\admin\models\User';
        $query = $class::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            // 'id_bidang' => $this->id_bidang,
        ]);

        $identity = Yii::$app->user->identity;
        $cek_unit_kerja_user = OfficeOrUnit::findOne(['unit_id' => $identity->id_cabang]);
        // var_dump($cek_unit_kerja_user->parent_id); exit();
        if($identity->is_admin == 2 && $cek_unit_kerja_user->parent_id == 0 && $identity->id_cabang != 1){
        $query->andFilterWhere(['like', 'id_cabang', $identity->id_cabang]);
        }else if($identity->is_admin == 2){
        $query->andFilterWhere(['like', 'id_bagian', $identity->id_bagian]);
        }


        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        if ($this->id_cabang != '') {
            $cek_unit_kerja = OfficeOrUnit::findOne(['unit_id' => $this->id_cabang]);
            if ($cek_unit_kerja['parent_id'] != '1') {
                $query->andFilterWhere(['like', 'id_cabang', $this->id_cabang, false]);
            } else {
                $query->andFilterWhere(['like', 'id_bagian', $this->id_cabang, false]);
            }
        }

        return $dataProvider;
    }
}
