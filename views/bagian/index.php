<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel appgudang\models\searchModel\BagianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Bagian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bagian-models-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bagian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NAMABAGIAN',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
