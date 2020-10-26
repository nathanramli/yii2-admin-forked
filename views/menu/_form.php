<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\Menu;
use yii\helpers\Json;
use mdm\admin\AutocompleteAsset;
use mdm\admin\models\searchs\Modul;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use mdm\admin\models\AuthItem;
use mdm\admin\models\Route;
use mdm\admin\models\Rute;
use yii\web\JsExpression;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */

// $query = Rute::find()->all();
// var_dump($query); exit();

AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => Menu::getMenuSource(),
    'routes' => Menu::getSavedRoutes(),
]);
$modul = ArrayHelper::map(Modul::find()->select(['id', 'name'])->asArray()->all(), 'id', 'name');
$parent = ArrayHelper::map(Menu::find(['parent' => new \yii\db\Expression("null")])->select(['id', 'name'])->asArray()->all(), 'id', 'name');
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<div class="menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

            <!-- <?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name']) ?> -->

            <?= $form->field($model, 'parent')->widget(Select2::classname(), [
                'data' => $parent,
                'language' => 'en',
                'options' => ['id' => 'id', 'placeholder' => 'Pilih Parent ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])->label("Parent " . Html::tag('small', '(optional)', ['class' => 'text-warning','style' => 'font-style: italic;']));
            ?>

            <?=
                $form->field($model, 'route')->widget(Select2::classname(), [
                    'id' => 'route',
                    'language' => 'us',
                    'options' => ['placeholder' => 'Pilih Rute ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Gagal mendapatkan Hasil..'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::toRoute(['menu/get-rute']),
                            'dataType' => 'json',
                            'delay' => 250,
                            'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                            'cache' => true
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(route) { return route.text; }')
                    ],
                ])->label("Rute");
            ?>



            <!-- <?= $form->field($model, 'route')->textInput(['id' => 'route']) ?> -->
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'order')->input('number') ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 2])->label("Data " . Html::tag('small', '(optional)', ['class' => 'text-warning','style' => 'font-style: italic;'])) ?>
            <?= $form->field($model, 'modul_id')->widget(Select2::classname(), [
                'data' => $modul,
                'language' => 'en',
                'options' => ['id' => 'modul_id', 'placeholder' => 'Pilih Modul ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?=
            Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord
                ? 'btn btn-success' : 'btn btn-primary'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>