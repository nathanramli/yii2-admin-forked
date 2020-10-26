<?php

namespace mdm\admin\models;


use Yii;
use mdm\admin\components\Configs;
use yii\db\Query;
use mdm\admin\models\AuthModul;
use mdm\admin\components\Helper;



/**
 * This is the model class for table "menu".
 *
 * @property integer $id Modul id(autoincrement)
 * @property string $name Modul name
 * @property integer $parent Modul parent
 * @property string $route Route for this menu
 * @property integer $order Modul order
 * @property string $data Extra information for this menu
 *
 * @property Modul $menuParent Modul parent
 * @property Modul[] $menus Modul children
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Modul extends \yii\db\ActiveRecord
{
    public $parent_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->modulTable;
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
            'id' => Yii::t('rbac-admin', 'ID'),
            'name' => Yii::t('rbac-admin', 'Name'),
        ];
    }

    public function getModuls()
    {
        return Modul::find()->all();
    }

    public function getModul($id)
    {
        return Modul::find(['id' => $id])->one();
    }

    public function getAuthModuls($id)
    {
        return AuthModul::find()->where(['user_id' => $id])->all();
    }

    public function inputModulBulk($items, $id)
    {
        $manager = new Modul;
        $success = 0;


        foreach ($items as $name) {
            // try {
                $manager->inputModulOne($name, $id);
                $success++;
            // } catch (\Exception $exc) {
            //     Yii::error($exc->getMessage(), __METHOD__);
            // }
        }
        Helper::invalidate();
        return $success;
    }

    /**
     * {@inheritdoc}
     */
    public function inputModulOne($role, $userId)
    {
        $modul = new AuthModul([
            'user_id' => $userId,
            'modul_name' => $role,
        ]);

        Yii::$app->db->createCommand()
            ->insert('auth_modul', [
                'user_id' => $modul->user_id,
                'modul_name' => $modul->modul_name,
            ])->execute();

        return $modul;
    }

      /**
     * Revokes a roles from a user.
     * @param array $items
     * @return integer number of successful revoke
     */
    public function revokeModulBulk($items, $id)
    {
        $manager = new Modul();
        $success = 0;
        foreach ($items as $name) {
                $manager->revokeModulOne($name, $id);
                $success++;
        }
        Helper::invalidate();
        return $success;
    }

        /**
     * {@inheritdoc}
     */
    public function revokeModulOne($role, $userId)
    {
  
        return $this->db->createCommand()
            ->delete('auth_modul', ['user_id' => (string) $userId, 'modul_name' => $role])
            ->execute() > 0;
    }

    public function getItems($id)
    {
        $available = [];
        foreach ($this->getModuls() as $name) {
            $available[$name->name] = 'modul';
        }


        $assigned = [];
        foreach ($this->getAuthModuls($id) as $item) {
            $assigned[$item->modul_name] = $available[$item->modul_name];
            unset($available[$item->modul_name]);
        }

        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }
}
