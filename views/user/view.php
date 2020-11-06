<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;
use common\models\Jabatan;
use common\models\OfficeOrUnit;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$controllerId = $this->context->uniqueId . '/';
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if ($model->status == 0 && Helper::checkRoute('/' . $controllerId . 'activate')) {
            echo Html::a(Yii::t('rbac-admin', 'Activate'), ['activate', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
        <?php
        // var_dump(Helper::checkRoute('/'.$controllerId . 'delete'));
        // if (Helper::checkRoute($controllerId . 'delete')) {
            echo Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        // }
        ?>
    </p>

    <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'nama',
                'nip',
                'passphrase',
                'is_admin',
                [
                    'attribute' => 'id_cabang',
                    'value' => function($model){
                        $m = OfficeOrUnit::findOne(['unit_id' => $model['id_cabang']]);
                        
                        return "<b>" . $m['code'] . "</b>: " . $m['name'];
                    },
                    'label' => 'Cabang',
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'id_jabatan',
                    'value' => function($model){
                        return Jabatan::findOne(['id' => $model['id_jabatan']])['nama_jabatan'];
                    },
                    'label' => 'Jabatan'
                ],
                'created_at:date'
            ],
        ])
    ?>

</div>