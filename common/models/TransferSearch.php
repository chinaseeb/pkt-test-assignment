<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transfer;

/**
 * TransferSearch represents the model behind the search form about `\common\models\Transfer`.
 */
class TransferSearch extends Transfer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dt', 'from_user_id', 'to_user_id'], 'integer'],
            [['fromUsername','toUsername'], 'save'],
            [['amount'], 'number'],
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
    public function search($user_id)
    {
        $query = Transfer::find();

        //join
        $query->joinWith(['fromUser AS f','toUser AS t']);
        
        //show only belonging transactions
        $query->where('from_user_id = :user_id OR to_user_id = :user_id',[':user_id'=>$user_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        $dataProvider->sort->attributes['fromUsername'] = [
             'asc' => ['f.username' =>  SORT_ASC],
            'desc' => ['f.username' => SORT_DESC]
        ];
        
        $dataProvider->sort->attributes['toUsername'] = [
             'asc' => ['t.username' =>  SORT_ASC],
            'desc' => ['t.username' => SORT_DESC]
        ];

        return $dataProvider;
    }
    
    
    public function all()
    {
        $query = Transfer::find();

        //join
        $query->joinWith(['fromUser AS f','toUser AS t']);
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        
        $dataProvider->sort->attributes['fromUsername'] = [
             'asc' => ['f.username' =>  SORT_ASC],
            'desc' => ['f.username' => SORT_DESC]
        ];
        
        $dataProvider->sort->attributes['toUsername'] = [
             'asc' => ['t.username' =>  SORT_ASC],
            'desc' => ['t.username' => SORT_DESC]
        ];

        return $dataProvider;
    }
}
