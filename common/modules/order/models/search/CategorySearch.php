<?php

namespace common\modules\order\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\order\models\Category;

/**
 * CategorySearch represents the model behind the search form of `common\modules\order\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order', 'status', 'parent_id'], 'integer'],
            [['title', 'background', 'url', 'icon','created_at'], 'safe'],
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
        $query = Category::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->asArray(),
            'pagination' => [
                'pageSize' => 10,
            ]
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
            'order' => $this->order,
            'status' => $this->status,
            'parent_id' => $this->parent_id,
        ]);

        if(!empty($this->created_at) && $this->created_at !== '')
        {
            $query->andFilterWhere([
                'like', 
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")', 
                date('Y-m-d',strtotime($this->created_at)),
            ]);
        }


        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'background', $this->background])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'icon', $this->icon]);
       
        return $dataProvider;
    }
}
