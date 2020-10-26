<?php

namespace mdm\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OfficeOrUnit;


/**
 * AssignmentSearch represents the model behind the search form about Assignment.
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Assignment extends Model
{
    public $id;
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rbac-admin', 'ID'),
            'username' => Yii::t('rbac-admin', 'Username'),
            'name' => Yii::t('rbac-admin', 'Name'),
        ];
    }

    /**
     * Create data provider for Assignment model.
     * @param  array                        $params
     * @param  \yii\db\ActiveRecord         $class
     * @param  string                       $usernameField
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params, $class, $usernameField)
    {
        $query = $class::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $identity = Yii::$app->user->identity;
        $cek_unit_kerja_user = OfficeOrUnit::findOne(['unit_id' => $identity->id_cabang]);
        // var_dump($cek_unit_kerja_user->parent_id); exit();
        if($identity->is_admin == 2 && $cek_unit_kerja_user->parent_id == 0 && $identity->id_cabang != 1){
        $query->andFilterWhere(['like', 'id_cabang', $identity->id_cabang]);
        }else if($identity->is_admin == 2){
        $query->andFilterWhere(['like', 'id_bagian', $identity->id_bagian]);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        

        $query->andFilterWhere(['like', $usernameField, $this->username]);

        return $dataProvider;
    }

    /**
     * Create data provider for Assignment model.
     * @param  array                        $params
     * @param  \yii\db\ActiveRecord         $class
     * @param  string                       $usernameField
     * @return \yii\data\ActiveDataProvider
     */
    public function searchNew($params)
    {
        $userClassName = 'mdm\admin\models\User';
        $query = $userClassName::find();
        $identity = Yii::$app->user->identity;
        $cek_unit_kerja_user = OfficeOrUnit::findOne(['unit_id' => $identity->id_cabang]);
        // var_dump($cek_unit_kerja_user->parent_id); exit();
        if($identity->is_admin == 2 && $cek_unit_kerja_user->parent_id == 0 && $identity->id_cabang != 1){
        $query->andFilterWhere(['like', 'id_cabang', $identity->id_cabang]);
        }else if($identity->is_admin == 2){
        $query->andFilterWhere(['like', 'id_bagian', $identity->id_bagian]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
      

        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
