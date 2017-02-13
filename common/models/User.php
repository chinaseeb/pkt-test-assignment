<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $authkey;
    public $created_at,$updated_at;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }
    
    
    public function getDeposit(){
        
        //sum all this user receive
        $amount = Transfer::find()->where([
                        'to_user_id'=>$this->id
                    ])->sum('amount');
        
        if($amount > 0){
            return $amount;
        } else {
            return 0;
        }
        
    }
    
    public function getWithdraw(){
        
        //sum all this user transfer
        $amount = Transfer::find()->where([
                        'from_user_id'=>$this->id
                    ])->sum('amount');
        
        if($amount > 0){
            return $amount;
        } else {
            return 0;
        }
        
    }
    
    
    public function getBalance(){
        
        $deposit =  $this->getDeposit();
        $withdraw = $this->getWithdraw();
        
        $balance = $deposit - $withdraw;
        
        return $balance;
        
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = static::findOne(['username' => $username]);
        
        if(is_a($user,User::className())){
            return $user;
        } else {
            $user = new User;
            $user->username=$username;
            $user->save();
            
            return $user;
        }
    }

    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey=null)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword()
    {
        return true;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    
    /**
     * @inheritdoc
     * override abstract method
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
}
