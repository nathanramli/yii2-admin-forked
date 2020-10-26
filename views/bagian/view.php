<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model appanggaran\models\BagianModels */

$this->title = $model->NAMABAGIAN;
$this->params['breadcrumbs'][] = ['label' => 'Bagian', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="bagian-models-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->IDBAGIAN], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->IDBAGIAN], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a("Kembali", ['index'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'IDBAGIAN',
                'label' => 'ID Bagian'
            ],
            [
                'attribute' => 'NAMABAGIAN',
                'label' => 'Nama Bagian'
            ]
        ],
    ]) ?>

</div>
