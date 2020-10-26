<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model appanggaran\models\BagianModels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bagian-models-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NAMABAGIAN')->textInput(['maxlength' => true])->label("Nama Bagian") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
