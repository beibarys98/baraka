<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\Orders $model */

$this->title = 'Тапсырыс беру';
?>
<div class="orders-create">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false, 
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
            'title',
            [
                'attribute' => 'quantity',
                'headerOptions' => ['style' => 'width: 10%;']
            ],
            [
                'attribute' => 'price',
                'headerOptions' => ['style' => 'width: 10%;']
            ],
        
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add}', // only show custom add button
                'buttons' => [
                    'add' => function ($url, $model, $key) {
                        return Html::a(
                            '+', // button text
                            ['order/add-item', 'id' => $model->id], // controller/action to handle add
                            [
                                'class' => 'btn btn-primary btn-sm',
                                'style' => 'width: 35px',
                                'title' => 'Тапсырысқа қосу',
                                'data-method' => 'post', // POST request
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <br>
    <br>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'summary' => false, 
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
            'item.title',
            [
                'attribute' => 'quantity',
                'enableSorting' => false,
                'headerOptions' => ['style' => 'width: 10%;']
            ],
            [
                'attribute' => 'item.price',
                'headerOptions' => ['style' => 'width: 10%;']
            ],
        
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add}', // only show custom add button
                'buttons' => [
                    'add' => function ($url, $model, $key) {
                        return Html::a(
                            '-', // button text
                            ['order-item/delete', 'id' => $model->id], // controller/action to handle add
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'style' => 'width: 35px',
                                'title' => 'Тапсырысқа қосу',
                                'data-method' => 'post', // POST request
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
