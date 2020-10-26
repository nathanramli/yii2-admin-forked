<?php

namespace mdm\admin\models;

use Yii;
use mdm\admin\components\Configs;
use yii\db\Query;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id Rute id(autoincrement)
 * @property string $name Rute name
 * @property integer $parent Rute parent
 * @property string $route Route for this menu
 * @property integer $order Rute order
 * @property string $data Extra information for this menu
 *
 * @property Rute $menuParent Rute parent
 * @property Rute[] $menus Rute children
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Rute extends \yii\db\ActiveRecord
{
    public $name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->ruteTable;
    }

    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        if (Configs::instance()->db !== null) {
            return Configs::instance()->db;
        } else {
            return parent::getDb();
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('rbac-admin', 'Name'),
        ];
    }

}
