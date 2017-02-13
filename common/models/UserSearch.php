<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `\common\models\User`.
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
            [['username'], 'safe'],
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
        
        $depositSubQuery = Transfer::find()->select('to_user_id AS tid, SUM(amount) AS deposit')->groupBy('to_user_id');
        $withdrawSubQuery = Transfer::find()->select('from_user_id AS fid, SUM(amount) AS withdraw')->groupBy('from_user_id');
        
        $query->leftJoin(['depositSub' => $depositSubQuery], 'depositSub.tid = user.id');
        $query->leftJoin(['withdrawSub' => $withdrawSubQuery], 'withdrawSub.fid = user.id');
        
        $query->select(['*','(COALESCE(deposit,0) - COALESCE(withdraw,0)) AS balance']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        $dataProvider->sort->attributes['balance'] = [
             'asc' => ['balance' =>  SORT_ASC],
            'desc' => ['balance' => SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
