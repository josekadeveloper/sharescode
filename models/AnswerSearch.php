<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Answer;
use Yii;

/**
 * AnswerSearch represents the model behind the search form of `\app\models\Answer`.
 */
class AnswerSearch extends Answer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'query_id', 'users_id'], 'integer'],
            [['content', 'date_created', 'query.title', 'user.portrait.nickname'], 'safe'],
        ];
    }

    public function attributes()
    {
       return array_merge(parent::attributes(), ['query.title', 'user.portrait.nickname']);
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
        if (Yii::$app->user->id) {
            $query = Answer::find()
                ->where(['answer.users_id' => Yii::$app->user->id])
                ->joinWith('query t')
                ->joinWith('user.portrait p');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['query.title'] = [
            'asc' => ['t.title' => SORT_ASC],
            'desc' => ['t.title' => SORT_DESC],
            
        ];

        $dataProvider->sort->attributes['user.portrait.nickname'] = [
            'asc' => ['p.nickname' => SORT_ASC],
            'desc' => ['p.nickname' => SORT_DESC],
            
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date_created' => $this->date_created,
            'query_id' => $this->query_id,
            'users_id' => $this->users_id,
        ]);

        $query->andFilterWhere(['ilike', 'content', $this->content])
              ->andFilterWhere(['ilike', 't.title', $this->getAttributes(['query.title'])])
              ->andFilterWhere(['ilike', 'p.nickname', $this->getAttributes(['user.portrait.nickname'])]);

        return $dataProvider;
    }
}
