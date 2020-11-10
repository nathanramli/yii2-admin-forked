<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use mdm\admin\components\Helper;
use common\models\OfficeOrUnit;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


$identity = Yii::$app->user->identity;
// var_dump($identity);

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create User'), ['signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                'nip',
                'nama',
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'id_cabang',
                    'value' => function ($model) {
                        $modUnit = OfficeOrUnit::find()->where(['unit_id' => $model->id_cabang])->one();
                        return (isset($modUnit->name) ? $modUnit->name : '');
                    },
                    'filter' => ArrayHelper::map(OfficeOrUnit::find()->asArray()->all(), 'unit_id', 'name'),
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['prompt' => 'Filter Cabang..'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '100%'
                        ],
                    ],
                    'label' => 'Cabang'

                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return $model->status == 0 ? 'Inactive' : 'Active';
                    },
                    'filter' => [
                        0 => 'Inactive',
                        10 => 'Active'
                    ]
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    // 'template' => Helper::filterActionColumn(['view', 'activates', 'delete']),
                    'template' => '{tombolAktiv} {view} {reset-password} {hapus} {edit}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'tombolAktiv') {
                            return Url::toRoute(['user/activate', 'id' => $model['id']]);
                        }
                    },
                    'buttons' => [
                        'tombolAktiv' => function ($url, $model) {
                            if ($model->status == 10) {
                                return '';
                            }
                            $options = [
                                'title' => Yii::t('rbac-admin', 'Activate'),
                                'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                                'data' => [
                                    'confirm' => 'Anda yakin ingin mengaktivasi user ini?',
                                    'method' => 'post',
                                ],
                            ];
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                        },
                        'reset-password' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['reset-password-new', 'id' => $model->id], [
                                'class' => 'btn btn-primary btn-sm', 
                                'title' => 'Reset Password',
                                'data-confirm' => 'Apakah anda yakin ingin mereset password user ini?',
                                'data' => [
                                    'confirm' => 'Apakah anda yakin ingin mereset password user ini?',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                        'edit' => function ($url, $model) {

                            return Html::a('<span class="glyphicon glyphicon-edit"></span>', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Edit User']);
                        },
                        'view' => function ($url, $model) {

                            return Html::a('<span class="glyphicon glyphicon-search"></span>', ['view', 'id' => $model->id], ['class' => 'btn btn-info btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Detail User']);
                        },
                        'hapus' => function ($url, $model) {
                            $options = [
                                'title' => Yii::t('rbac-admin', 'Hapus'),
                                'aria-label' => Yii::t('rbac-admin', 'Hapus'),
                                'data-confirm' => Yii::t('rbac-admin', 'Anda yakin ingin Menghapus user ini?'),
                                'class' => 'btn btn-danger btn-sm', 
                                'data-toggle' => 'tooltip', 
                                'data' => [
                                    'confirm' => 'Anda yakin ingin Menghapus user ini?',
                                    'method' => 'post',
                                ],
                            ];

                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], $options);
                        },
                    ]
                ],
            ],
        ]);
    ?>
</div>