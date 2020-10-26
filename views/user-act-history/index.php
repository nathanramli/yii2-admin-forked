<?php

use kartik\grid\GridView as KartikGridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\UserActHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Act Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-act-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        // echo Html::a('Create User Act History', ['create'], ['class' => 'btn btn-success']) 
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= KartikGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_user',
            'username',
            'nama',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'act',
                'value' => function($model){
                    switch($model['act']){
                        case 1:
                            return "login";
                    }
                },
                'label' => 'Jenis Aksi'
            ],
            [
                'attribute' => 'url',
                'enableSorting' => false
            ],
            'modul',
            'keterangan',
            [
                'attribute' => 'tanggal',
                'filterType' => KartikGridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'startAttribute' => 'tanggal_awal',
                    'endAttribute' => 'tanggal_akhir',
                    'convertFormat' => true,
                    'presetDropdown' => true,
                    'defaultPresetValueOptions' => ['style' => 'display:none'],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        // 'timePicker'=>true, //Display time //'Time Picker Increment'=>5, //min interval
                        // 'timePicker24Hour' => true, //24 hour system
                        'locale' => ['format' => 'Y-m-d H:i:s'], //php formatting time
                    ],
                ],        
            ],

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
