<?php

namespace app\models\variations;

use Yii;

/**
 * This is the model class for table "variation_items".
 *
 * @property int $variation_id
 * @property int $product_id
 * @property int $props_id
 * @property string $props_name
 *
 * @property Products $product
 * @property Variations $variation
 */
class VariationItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variation_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['variation_id', 'product_id', 'props_id', 'props_name'], 'required'],
            [['variation_id', 'product_id', 'props_id'], 'integer'],
            [['props_name'], 'string', 'max' => 255],
            //[['variation_id'], 'unique'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
            [['variation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variations::class, 'targetAttribute' => ['variation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'variation_id' => 'Variation ID',
            'product_id' => 'Product ID',
            'props_id' => 'Props ID',
            'props_name' => 'Props Name',
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
     * Gets query for [[Variation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariation()
    {
        return $this->hasOne(Variations::class, ['id' => 'variation_id']);
    }
}
