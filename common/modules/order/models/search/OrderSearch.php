<?php

namespace common\modules\order\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\order\models\Order;
use yii\data\ArrayDataProvider;

/**
 * OrderSearch represents the model behind the search form of `common\modules\order\models\Order`.
 */
class OrderSearch extends Order
{   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'category_id', 'status'], 'integer'],
            [['content', 'author_name', 'author_phone'], 'safe'],
            [['created_at'],'safe'],
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->asArray(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        // add conditions that should always apply here

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        if(!empty($this->created_at) && $this->created_at !== '')
        {
            $query->andFilterWhere([
                'like', 
                'FROM_UNIXTIME(created_at, "%Y-%m-%d")', 
                date('Y-m-d',strtotime($this->created_at)),
            ]);
        }

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'author_phone', $this->author_phone])->asArray()->all();

        

        return $dataProvider;
    }
}
