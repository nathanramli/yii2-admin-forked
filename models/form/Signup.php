<?php
namespace mdm\admin\models\form;

use mdm\admin\components\UserStatus;
use mdm\admin\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class Signup extends Model
{
    public $username;
    public $email;
    public $id_cabang;
    public $is_admin;
    public $id_jabatan;
    public $nip;
    public $passphrase;
    public $isNewRecord;
    public $nama;
    public $password;
    public $retypePassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => $class, 'message' => 'This email address has already been taken.'],

            [['id_cabang'], 'string', 'max' => 128],
            [['is_admin'], 'string', 'max' => 128],
            [['nama'], 'string', 'max' => 128],
            ['id_jabatan', 'required'],
            [['nip', 'passphrase'], 'safe'],


            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['retypePassword', 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
            $user = new $class();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->id_cabang = $this->id_cabang;
            $user->id_jabatan = $this->id_jabatan;
            $user->is_admin = $this->is_admin;
            $user->nip = $this->nip;
            $user->passphrase = $this->passphrase;
            $user->nama = $this->nama;
            $user->status = ArrayHelper::getValue(Yii::$app->params, 'user.defaultStatus', UserStatus::ACTIVE);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
