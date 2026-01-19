<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property string $title
 * @property int $quantity
 * @property float $price
 *
 * @property OrderItem[] $orderItems
 */
class Items extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantity'], 'default', 'value' => 1],
            [['price'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['quantity'], 'integer'],
            [['price'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Атауы',
            'quantity' => 'Саны',
            'price' => 'Бағасы',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\OrderItemQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['item_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ItemsQuery(get_called_class());
    }

}
