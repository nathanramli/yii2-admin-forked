<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserActHistory */

$this->title = 'Create User Act History';
$this->params['breadcrumbs'][] = ['label' => 'User Act Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-act-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
