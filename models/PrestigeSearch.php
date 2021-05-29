<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prestige;

/**
 * PrestigeSearch represents the model behind the search form of `\app\models\Prestige`.
 */
class PrestigeSearch extends Prestige
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'score', 'users_id'], 'integer'],
            [['type_prestige', 'antiquity'], 'safe'],
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
        $query = Prestige::find();

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
            'antiquity' => $this->antiquity,
            'score' => $this->score,
            'users_id' => $this->users_id,
        ]);

        $query->andFilterWhere(['ilike', 'type_prestige', $this->type_prestige]);

        return $dataProvider;
    }
}
