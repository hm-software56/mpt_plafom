<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'password', 'type', 'status', 'created_at', 'full_name'], 'safe'],
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
        $query = User::find();

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
            'created_at' => $this->created_at,
        ]);
		$getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
        if(in_array($getuser->type, Yii::$app->params['type_user_register']))
        {
            $query->andFilterWhere(['in', 'type', Yii::$app->params['type_user_register']]);
        }elseif($getuser->type !="Super Admin")
		{
			$query->andFilterWhere(['not in', 'type', array_merge(['Super Admin'],Yii::$app->params['type_user_register'])]);
		}
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['type'=> $this->type])
            ->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

}
