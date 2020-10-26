<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model appanggaran\models\BagianModels */

$this->title = 'Create Bagian Models';
$this->params['breadcrumbs'][] = ['label' => 'Bagian Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bagian-models-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
