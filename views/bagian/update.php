<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model appanggaran\models\BagianModels */

$this->title = 'Update Data Bagian: ' . $model->NAMABAGIAN;
$this->params['breadcrumbs'][] = ['label' => 'Bagian Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IDBAGIAN, 'url' => ['view', 'id' => $model->IDBAGIAN]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bagian-models-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
