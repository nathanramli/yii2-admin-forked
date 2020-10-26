<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model appgudang\models\searchModel\BagianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bagian-models-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IDBAGIAN') ?>

    <?= $form->field($model, 'NAMABAGIAN') ?>

    <?= $form->field($model, 'INDUK') ?>

    <?= $form->field($model, 'CODE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
