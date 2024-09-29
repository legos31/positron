<?php

namespace app\models\variations;

use Yii;

/**
 * This is the model class for table "products_types".
 *
 * @property int $id
 * @property int $types_id
 * @property string $name
 * @property int $product_id
 *
 * @property Products $product
 * @property ProductTypesProps $types
 */
class ProductsTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['types_id', 'name', 'product_id'], 'required'],
            [['types_id', 'product_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
            [['types_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTypesProps::class, 'targetAttribute' => ['types_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'types_id' => 'Types ID',
            'name' => 'Name',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Types]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasOne(ProductTypesProps::class, ['id' => 'types_id']);
    }
}
