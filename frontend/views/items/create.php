<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Items $model */

$this->title = 'Тағам қосу';
?>
<div class="items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
