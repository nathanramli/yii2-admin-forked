<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OfficeOrUnit */

$this->title = 'Update Unit kerja: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Unit kerja', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->unit_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="office-or-unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
