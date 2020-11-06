<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\BagianModels;
use common\models\OfficeOrUnit;
use common\models\Jabatan;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = "Daftarkan User Baru";
$this->params['breadcrumbs'][] = $this->title;
// Get Data Bagian
$modbagian = BagianModels::find()->select(['IDBAGIAN', new \yii\db\Expression("NAMABAGIAN")])->all();
$bidang = ArrayHelper::map($modbagian, 'IDBAGIAN', 'NAMABAGIAN');

/***
 * Cek jika admin adalah admin cabang
 */
$modcabangac = OfficeOrUnit::find()->select(['unit_id', new \yii\db\Expression("name")]);

if(Yii::$app->user->identity->is_admin != 1)
    $modcabangac->where(["unit_id" => Yii::$app->user->identity->id_cabang]);
else{
    $modcabangac->where(["parent_id" => 0])
        ->orWhere("code IN ('30', '31')");
}
$modcabang = $modcabangac->all();

$cabang = ArrayHelper::map($modcabang, 'unit_id', 'name');

$identity = Yii::$app->user->identity;

if ($identity->is_admin == '1') {
    $role = ['0' => 'Member', '1' => 'Admin Pusat', '2' => 'Admin Unit Cabang'];
} else {
    $role = ['0' => 'Member', '2' => 'Admin Unit Cabang'];
}
$js = "
$('#parent_id').change(function(){
    let val = $(this).val();
    if(val == '1'){
        $('.field-bagian').show({
        });
    }else{
        $('.field-bagian').hide({
        });
    }
});
$('#parent_id').trigger('change');
";

$this->registerJs(
    $js,
    View::POS_READY,
    'my-button-handler'
);
?>
<div class="site-signup">
    <?php if ($model->isNewRecord) { ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Silahkan Memasukan Data User Baru:</p>
    <?php } ?>
    <?= Html::errorSummary($model) ?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'nama') ?>
            <?php if ($model->isNewRecord) { ?>
                <?= $form->field($model, 'username') ?>
            <?php } ?>

            <?= $form->field($model, 'nip')->textInput() ?>
            
            <?= $form->field($model, 'passphrase')->textInput() ?>
            
            <?= $form->field($model, 'id_cabang')->widget(Select2::classname(), [
                'data' => $cabang,
                'language' => 'en',
                'options' => [
                    'id' => 'parent_id', 
                    'placeholder' => 'Pilih Cabang ...'
                ] + 
                // Append dengan options value
                ($model->isNewRecord ? ['value' => Yii::$app->user->identity->id_cabang] : [])
            ])->label('Cabang'); ?>

            <?= $form->field($model, 'id_jabatan')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Jabatan::find()->all(), 'id', 'nama_jabatan'),
                'language' => 'en',
                'options' => ['id' => 'jabatan', 'placeholder' => 'Pilih Jabatan ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Jabatan');
            ?>

            <?= $form->field($model, 'is_admin')->widget(Select2::classname(), [
                'data' => $role,
                'language' => 'en',
                'options' => ['id' => 'is_admin', 'placeholder' => 'Pilih Role User ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Role');
            ?>
            <?php if ($model->isNewRecord) { ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'retypePassword')->passwordInput() ?>
            <?php } ?>

            <div class="form-group">
                <!-- <?= Html::submitButton(Yii::t('rbac-admin', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?> -->
            <?php
            echo Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Signup') : Yii::t('rbac-admin', 'Update'), [
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'name' => 'signup-button'
            ])
            ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>