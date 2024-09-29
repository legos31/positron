<?php

namespace app\models\variations;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "variations".
 *
 * @property int $id
 * @property int $category_id
 * @property int $active
 *
 * @property VariationItems $variationItems
 */
class Variations extends \yii\db\ActiveRecord
{

    public $_articles;
    public $_props;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'active'], 'required'],
            [['category_id', 'active'], 'integer'],
            [[ '_articles', '_props'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[VariationItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVariationItems()
    {
        return $this->hasMany(VariationItems::class, ['variation_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        //dd($this);
        parent::afterSave($insert, $changedAttributes);

        $variations = VariationItems::find()->where(['variation_id' => $this->id])->all();
        foreach ($variations as $variation) {
            $variation->delete();
        }

        if ((is_array($this->_articles)) && (count($this->_articles) > 0)) {
            foreach ($this->_articles as $key=>$articleId) {
                foreach ($this->_props as $key => $propId) {
                    $variationItem = new VariationItems ();
                    $variationItem->variation_id = $this->id;
                    $variationItem->product_id = $articleId;
                    $variationItem->props_id = $propId;
                    $variationItem->props_name = ProductTypesProps::findOne($propId)->name;
                    $variationItem->save();
                }
            }
        }
    }

    public function afterFind() {
        $this->_articles = $this->productsArticle;
        $this->_props = $this->productsProps;
    }

    public function getProducts()
    {
        return $this->hasMany(Products::class, ['id' => 'product_id'])->via('variationItems');
    }

    public function getProductsArticle()
    {
        $query = $this->getProducts();
        return ArrayHelper::getColumn($query->all(), 'id');
    }


    public function getVariationsItems()
    {
        return $this->hasMany(VariationItems::class, ['variation_id' => 'id']);
    }

    public function getProductsProps()
    {
        $query = $this->getVariationsItems();
        return ArrayHelper::map($query->all(), 'props_id', 'props_id');
    }
}
