<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ContentCategory;

/**
 * ContentCategorySearch represents the model behind the search form about `backend\models\ContentCategory`.
 */
class ContentCategorySearch extends ContentCategory
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'has_summary', 'has_details', 'has_photo', 'has_keywords', 'has_meta_keywords', 'has_start_date', 'has_end_date', 'has_multi_attachment', 'created_by', 'updated_by', 'is_legal_type'], 'integer'],
            [['title', 'status', 'created_date', 'updated_date'], 'safe'],
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
        $query = ContentCategory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'has_summary' => $this->has_summary,
            'has_details' => $this->has_details,
            'has_photo' => $this->has_photo,
            'has_keywords' => $this->has_keywords,
            'has_meta_keywords' => $this->has_meta_keywords,
            'has_start_date' => $this->has_start_date,
            'has_end_date' => $this->has_end_date,
            'has_multi_attachment' => $this->has_multi_attachment,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_legal_type' => $this->is_legal_type,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

}
