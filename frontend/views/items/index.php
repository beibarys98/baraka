<?php

use common\models\Items;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ItemsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Меню';
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Тағам қосу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Тағам саны: {totalCount}", 
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
                'headerOptions' => [
                    'style' => 'width: 10%;'
                ]
            ],
             [
                'attribute' => 'price',
                'headerOptions' => [
                    'style' => 'width: 10%;'
                ]
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update}<span style="margin-right: 15px"></span>{delete}',
                'urlCreator' => function ($action, Items $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>