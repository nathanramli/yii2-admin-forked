<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OfficeOrUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Unit Kerja';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-or-unit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Unit Kerja', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'unit_id',
            'code',
            'name',
            'abbreviation',
            'parent_id',
            //'depth',
            //'ordinal',
            //'city',
            //'address:ntext',
            //'initialoffice',
            'type_cab',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
