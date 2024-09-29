<?php

namespace app\models\variations;

use Yii;

/**
 * This is the model class for table "product_types_props".
 *
 * @property int $id
 * @property string $name
 *
 * @property ProductsTypes[] $productsTypes
 */
class ProductTypesProps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_types_props';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    /**
     * Gets query for [[ProductsTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductsTypes()
    {
        return $this->hasMany(ProductsTypes::class, ['types_id' => 'id']);
    }
}
