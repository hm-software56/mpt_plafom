<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Issue;

/**
 * IssueSearch represents the model behind the search form about `backend\models\Issue`.
 */
class IssueSearch extends Issue
{
    /**
     * @inheritdoc
     */
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['id', 'issue_category_id'], 'integer'],
            [['name', 'email', 'subject', 'message', 'telephone', 'file', 'created_date', 'date_from', 'date_to'], 'safe'],
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
        $query = Issue::find();

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
            'issue_category_id' => $this->issue_category_id,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'file', $this->file]);
        if (isset($this->date_from) && !empty($this->date_from)) {
            $query->andFilterWhere(['>=', 'created_date', date('Y-m-d H:i:s', strtotime($this->date_from))]);
        }
        if (isset($this->date_to) && !empty($this->date_to)) {
            $query->andFilterWhere(['<=', 'created_date', date('Y-m-d H:i:s', strtotime($this->date_to))]);
        }

        return $dataProvider;
    }

}
