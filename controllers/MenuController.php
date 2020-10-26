<?php

namespace mdm\admin\controllers;

use yii\filters\AccessControl;
use Yii;
use mdm\admin\models\Menu;
use mdm\admin\models\searchs\Menu as MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\Helper;
use mdm\admin\models\Rute;

// use mdm\admin\models\searchs\AuthItem;

/**
 * MenuController implements the CRUD actions for Menu model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class MenuController extends Controller
{

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
                    // 'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $searchModel = new MenuSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // if ($model->menuParent) {
        //     $model->parent_name = $model->menuParent->name;
        // }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Helper::invalidate();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'menu' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /* 
         * Get Object Model
         */
        $model = $this->findModel($id);
        $name = $model->name;
        $model->delete();

        Helper::invalidate(); 
        Yii::$app->session->setFlash("success", "Berhasil menghapus menu <b>\"{$name}\"</b>.");

        return $this->redirect(['index']);
    }

    /**
     * Get saved routes.
     * @return array
     */
    private static $name;
    public static function actionGetRute($q = null, $id = null)
    {

        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = "SELECT name as id, name as text FROM " . Yii::$app->params['dbadmin'].".dbo.".Rute::tableName() . " WHERE (name LIKE '/%' AND name LIKE '{$q}%')";
            $data = Yii::$app->db->createCommand($query)->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => '', 'text' => Rute::find()->where(['name' => $id])->one()['name']];
        }
        return json_encode($out);
       
    }
   
    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
