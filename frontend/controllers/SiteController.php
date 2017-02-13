<?php
namespace frontend\controllers;

use Yii;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','logout'],
                'rules' => [
                    [
                        'actions' => ['index','all-balance','logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    
    /**
     * Displays personal page each user
     *
     * @return mixed
     */
    public function actionIndex()
    {
        
        $user_id = Yii::$app->user->id;
        $user = \common\models\User::findOne($user_id);
        
        $model = new \common\models\Transfer();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $to_user = \common\models\User::findByUsername($model->to_username);
            $model->to_user_id = $to_user->id;
            
            $model->save();
            
            $model = new \common\models\Transfer();
        } 
        
        $transactions = \common\models\TransferSearch::Search($user_id);
        
        return $this->render('index',[
                'model' => $model,
                'user' => $user,
                'transactions' => $transactions
            ]);
        
    }
    
    /**
     * Displays all balances 
     *
     * @return mixed
     */
    public function actionAllBalance()
    {
    
        $searchModel = new \common\models\UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('all-balance', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        
        
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
