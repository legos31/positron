<?php

namespace app\models\variations;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property int $gcode
 *
 * @property ProductsTypes[] $productsTypes
 * @property VariationItems[] $variationItems
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'gcode'], 'required'],
            [['gcode'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'gcode' => 'Gcode',
        ];
    }

    /**
     * Gets query for [[ProductsTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsTypes()
    {
        return $this->hasMany(ProductsTypes::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[VariationItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariationItems()
    {
        return $this->hasMany(VariationItems::class, ['product_id' => 'id']);
    }
}
