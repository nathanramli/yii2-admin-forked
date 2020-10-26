<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OfficeOrUnit */

$this->title = 'Create Office Or Unit';
$this->params['breadcrumbs'][] = ['label' => 'Office Or Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-or-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
