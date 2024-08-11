<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Books;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * BooksSearch represents the model behind the search form of `app\models\Books`.
 */
class BooksSearch extends Books
{
    public $authors;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pageCount', 'publishedDate', 'status'], 'integer'],
            [['title', 'isbn', 'thumbnailUrl', 'shortDescription', 'longDescription', 'authors'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Books::find()->joinWith('authors');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['authors'] = [
            'asc' => ['authors.name' => SORT_ASC],
            'desc' => ['authors.name' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pageCount' => $this->pageCount,
            'publishedDate' => $this->publishedDate,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'thumbnailUrl', $this->thumbnailUrl])
            ->andFilterWhere(['like', 'shortDescription', $this->shortDescription])
            ->andFilterWhere(['like', 'authors.name', $this->authors])
            ->andFilterWhere(['like', 'longDescription', $this->longDescription]);

        return $dataProvider;
    }
}
