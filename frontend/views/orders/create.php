<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\Orders $model */
/** @var $orderId */

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
                'template' => '{add}',
                'buttons' => [
                    'add' => function ($url, $model) use ($orderId) {
                        return Html::a(
                            '+',
                            'javascript:void(0);',
                            [
                                'class' => 'btn btn-primary btn-sm add-item-btn',
                                'data-order-id' => $orderId,
                                'data-item-id' => $model->id,
                                'title' => 'Тапсырысқа қосу',
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
        'rowOptions' => function ($model) {
            return ['id' => 'order-item-' . $model->item_id];
        },
        'columns' => [
            'item.title',
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'value' => function($model) {
                    return '<span class="qty">' . $model->quantity . '</span>';
                },
                'enableSorting' => false,
            ],
            'item.price',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{remove}',
                'buttons' => [
                    'remove' => function ($url, $model) {
                        return Html::a(
                            '-',
                            'javascript:void(0);',
                            [
                                'class' => 'btn btn-danger btn-sm remove-item-btn',
                                'data-id' => $model->id,
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>

<?php
\yii\widgets\PjaxAsset::register($this);
$addUrl = \yii\helpers\Url::to(['/orders/add-item']);

$js = <<<JS
$(document).on('click', '.add-item-btn', function () {
    const btn = $(this);
    const orderId = btn.data('order-id');
    const itemId = btn.data('item-id');
    const stock = parseInt(btn.data('stock')); // stock from data attribute

    if (stock <= 0) {
        alert('Cannot add, item out of stock');
        return;
    }

    $.post('$addUrl', {
        orderId: orderId,
        itemId: itemId,
        _csrf: yii.getCsrfToken()
    }).done(function(res) {
        if (res.success) {
            const row = $('#order-item-' + res.itemId);
            if (row.length) {
                row.find('.qty').text(res.quantity);
            } else if (typeof $.pjax !== 'undefined') {
                $.pjax.reload({container: '#order-items-pjax'});
            }
            // update stock attribute
            btn.data('stock', res.stock);
            if (res.stock <= 0) btn.prop('disabled', true);
        } else {
            alert(res.message || 'Failed to add item');
        }
    });
});

JS;

$this->registerJs($js);
?>


