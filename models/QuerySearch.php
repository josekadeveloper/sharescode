<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Query;

/**
 * QuerySearch represents the model behind the search form of `\app\models\Query`.
 */
class QuerySearch extends Query
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'portrait_id'], 'integer'],
            [['title', 'explanation', 'date_created'], 'safe'],
            [['is_closed'], 'boolean'],
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
        $query = Query::find();

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
            'date_created' => $this->date_created,
            'is_closed' => $this->is_closed,
            'portrait_id' => $this->portrait_id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'explanation', $this->explanation]);

        return $dataProvider;
    }
}
