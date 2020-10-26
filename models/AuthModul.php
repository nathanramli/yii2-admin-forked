<?php

namespace mdm\admin\models;

use Yii;
use mdm\admin\components\Configs;
use yii\db\Query;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id AuthModul id(autoincrement)
 * @property string $name AuthModul name
 * @property integer $parent AuthModul parent
 * @property string $route Route for this menu
 * @property integer $order AuthModul order
 * @property string $data Extra information for this menu
 *
 * @property AuthModul $menuParent AuthModul parent
 * @property AuthModul[] $menus AuthModul children
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AuthModul extends \yii\db\ActiveRecord
{
    public $parent_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->authModulTable;
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
            [['modul_id', 'user_id', 'modul_name'], 'required'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'modul_id' => Yii::t('rbac-admin', 'ID'),
            'user_id' => Yii::t('rbac-admin', 'Name'),
        ];
    }

}