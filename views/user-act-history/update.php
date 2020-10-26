<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserActHistory */

$this->title = 'Update User Act History: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Act Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-act-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
