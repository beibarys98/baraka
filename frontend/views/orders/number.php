<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Orders $model */

$this->title = 'Тапсырыс беру';
?>
<div class="orders-create container mt-5">

    <div class="card shadow-sm">
        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'number')->input('number',[
                'maxlength' => true, 
                'placeholder' => 'Кілт нөмірін енгізіңіз',
                'autofocus' => true
            ])->label(false) ?>

            <div class="form-group mt-4">
                <?= Html::submitButton('Сақтау', ['class' => 'btn btn-success w-100']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
