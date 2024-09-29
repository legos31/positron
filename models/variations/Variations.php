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
            [[ '_articles'], 'safe'],
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
            foreach ($this->_articles as $key=>$id) {
                $variationItem = new VariationItems ();
                $variationItem->variation_id = $this->id;
                $variationItem->product_id = $id;
                $variationItem->props_id = rand(1, 4);
                $variationItem->props_name = 'Test name';
                $variationItem->save();
            }
        }
    }

    public function afterFind() {
        $this->_articles = $this->productsArticle;
    }

    public function getProducts()
    {
        return $this->hasMany(Products::class, ['id' => 'product_id'])->via('variationItems');
    }

    public function getProductsArticle()
    {
        $query = $this->getProducts();
        return ArrayHelper::map($query->all(), 'id', 'id');
    }
}
