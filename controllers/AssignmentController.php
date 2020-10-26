<?php

namespace mdm\admin\controllers;

use yii\filters\AccessControl;
use Yii;
use mdm\admin\models\Assignment;
use mdm\admin\models\Modul;
use mdm\admin\models\searchs\Assignment as AssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * AssignmentController implements the CRUD actions for Assignment model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AssignmentController extends Controller
{
    public $userClassName;
    public $idField = 'id';
    public $usernameField = 'username';
    public $fullnameField;
    public $searchClass;
    public $extraColumns = [];

     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'assign' => ['post'],
                    'assign' => ['post'],
                    'revoke' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ? : 'mdm\admin\models\User';
        }
    }


    /**
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        // if (Yii::$app->user->isGuest) {
        //     return $this->goHome();
        // }

        // if ($this->searchClass === null) {
            $searchModel = new AssignmentSearch;
            // $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(), $this->userClassName, $this->usernameField);
        // } else {
            // $searchModel->username = '';
            $dataProvider = $searchModel->searchNew(Yii::$app->request->queryParams);
        // }
        // var_dump($searchModel);

        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'idField' => $this->idField,
                'usernameField' => $this->usernameField,
                'extraColumns' => $this->extraColumns,
        ]);
    }

    /**
     * Displays a single Assignment model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
                'model' => $model,
                'idField' => $this->idField,
                'usernameField' => $this->usernameField,
                'fullnameField' => $this->fullnameField,
        ]);
    }


    public function actionViewModul($id)
    {
        $model = $this->findModel($id);
        $modul = Modul::findOne(['id' => $id]);
        if(!$modul) $modul = new Modul;

        return $this->render('view-modul', [
                'model' => $model,
                'modul' => $modul,
                'idField' => $this->idField,
                'usernameField' => $this->usernameField,
                'fullnameField' => $this->fullnameField,
        ]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->assign($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionInsertModul($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Modul();
        
        $success = $model->inputModulBulk($items, $id);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems($id), ['success' => $success]);
    }


    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionRevoke($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->revoke($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionRevokeModul($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Modul();
        $success = $model->revokeModulBulk($items, $id);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems($id), ['success' => $success]);
    }

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return new Assignment($id, $user);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
