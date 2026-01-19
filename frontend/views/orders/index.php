<?php

use common\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Тапсырыстар';
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Тапсырыс беру', ['number'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Тапсырыс саны: {totalCount}", 
        'tableOptions' => [
            'class' => 'table table-sm table-striped'
        ],
        'emptyText' => 'Ештеңе жоқ',
        'emptyTextOptions' => [
            'class' => 'empty text-muted',
        ],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
        ],
        'columns' => [
            [
                'attribute' => 'number',
                'headerOptions' => [
                    'style' => 'width: 10%;'
                ]
            ],
            'status',
            [
                'attribute' => 'sum',
                'headerOptions' => [
                    'style' => 'width: 20%;'
                ]
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
