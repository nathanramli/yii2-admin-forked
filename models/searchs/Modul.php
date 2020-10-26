<?php

namespace mdm\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use mdm\admin\models\Modul as ModulModel;

/**
 * Modul represents the model behind the search form about [[\mdm\admin\models\Modul]].
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Modul extends ModulModel
{

    /**
     * @inheritdoc
     */
    public $name;
    public function rules()
    {
        return [
            [['id', 'name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return ModulModel::scenarios();
    }

    /**
     * Searching Modul
     * @param  array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
          /* @var $query \yii\db\ActiveQuery */
          $query = ModulModel::find();
  
          $dataProvider = new ActiveDataProvider([
              'query' => $query,
          ]);
  
          $this->load($params);
  
  
          $query->andFilterWhere(['like', 'name', $this->name]);
  
          return $dataProvider;
    }
}
