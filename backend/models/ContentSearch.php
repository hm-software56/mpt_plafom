<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Content;

/**
 * ContentSearch represents the model behind the search form about `backend\models\Content`.
 */
class ContentSearch extends Content
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content_category_id', 'created_by', 'updated_by'], 'integer'],
            [['title', 'summary', 'details', 'photo', 'keywords', 'meta_keywords', 'start_date', 'end_date', 'created_date', 'updated_date', 'status', 'ref'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Content::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $this->content_category_id = Yii::$app->session['type'];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'content_category_id' => $this->content_category_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'details', $this->details])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'ref', $this->ref]);

        $query->orderBy("id DESC");

        return $dataProvider;
    }

}
