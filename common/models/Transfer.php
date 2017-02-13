<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transfer".
 *
 * @property integer $id
 * @property integer $dt
 * @property integer $from_user_id
 * @property integer $to_user_id
 *
 * @property User $toUser
 * @property User $fromUser
 */
class Transfer extends \yii\db\ActiveRecord
{
    public $balance;
    public $to_username;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dt', 'from_user_id', 'to_user_id', 'to_username'], 'required'],
            [['dt', 'from_user_id', 'to_user_id'], 'integer'],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
            [['amount'] , 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt' => 'Datetime',
            'from_user_id' => 'From',
            'to_user_id' => 'To',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'to_username' => 'Transfer to',
            'fromUsername'=> 'From',
            'toUsername'=>'To'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }
    
    
    public function getFromUsername()
    {
        if(is_object($this->fromUser)){
            return $this->fromUser->username;
        } else {
            return null;
        }
    }
    
    public function getToUsername()
    {
        if(is_object($this->toUser)){
            return $this->toUser->username;
        } else {
            return null;
        }
    }
    
}
