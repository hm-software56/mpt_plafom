<?php

namespace backend\modules\event\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\event\models\Event;
use backend\models\User;

/**
 * EventSearch represents the model behind the search form about `backend\modules\event\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by'], 'integer'],
            [['event_title', 'agenda', 'date_start', 'time_start', 'date_end', 'time_end', 'location', 'host', 'register_deadline'], 'safe'],
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
        $query = Event::find();

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
            'date_start' => $this->date_start,
            'time_start' => $this->time_start,
            'date_end' => $this->date_end,
            'time_end' => $this->time_end,
            'created_by' => $this->created_by,
            'register_deadline' => $this->register_deadline,
        ]);

        $query->andFilterWhere(['like', 'event_title', $this->event_title])
            ->andFilterWhere(['like', 'agenda', $this->agenda])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'host', $this->host]);
        
        $getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
        if($getuser->type=="Register")
        {
            $query->andWhere(['user_id'=>Yii::$app->user->id]);
        }
        
        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
