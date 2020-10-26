<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use mdm\admin\components\Helper;
use common\models\OfficeOrUnit;
use appanggaran\models\BagianModels;
use appgudang\models\masterData\KelompokPetugas;
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
                'nama',
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'id_cabang',
                    'value' => function ($model) {
                        if ($model->id_cabang != 1) {
                            $modUnit = OfficeOrUnit::find()->where(['unit_id' => $model->id_cabang])->one();
                        } else {
                            $modUnit = OfficeOrUnit::find()->where(['unit_id' => $model->id_bagian])->one();
                        }
                        return (isset($modUnit->name) ? $modUnit->name : '');
                    },
                    'filter' => ArrayHelper::map(OfficeOrUnit::find()->asArray()->all(), 'unit_id', 'name'),
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['prompt' => 'Filter Unit Kerja..'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '100%'
                        ],
                    ],
                    'label' => 'Unit Kerja'

                ],
                [
                    'class' => '\kartik\grid\DataColumn',
                    'attribute' => 'id_bidang',
                    'value' => function ($model) {
                        $modUnit = BagianModels::find()->where(['IDBAGIAN' => $model->id_bidang])->one();
                        return (isset($modUnit->NAMABAGIAN) ? $modUnit->NAMABAGIAN : '');
                    },
                    'filter' => ArrayHelper::map(BagianModels::find()->asArray()->all(), 'IDBAGIAN', 'NAMABAGIAN'),
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'options' => ['prompt' => 'Filter Unit Kerja..'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'width' => '100%'
                        ],
                    ],
                    'label' => 'Bidang',

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
                    'template' => '{tombolAktiv} {reset-password} {hapus} {edit}',
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

                            return Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['reset-password-new', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Reset Password']);
                        },
                        'edit' => function ($url, $model) {

                            return Html::a('<span class="glyphicon glyphicon-edit"></span>', ['update', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data-toggle' => 'tooltip', 'title' => 'Edit User']);
                        },
                        'hapus' => function ($url, $model) {
                            $options = [
                                'title' => Yii::t('rbac-admin', 'Hapus'),
                                'aria-label' => Yii::t('rbac-admin', 'Hapus'),
                                'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to Delete this user?'),
                                'class' => 'btn btn-success btn-sm', 
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