<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $model common\models\Tranfer */
/* @var $transactions common\models\TranferSearch */

$this->title = 'main';
?>
<div class="site-index">
    
    <div class="row">
        
        <div class="col-lg-12 col-md-12">
            <h1><?= $user->username ?></h1>
        </div>
        
    </div>    
    
    <div class="row">
        
        <?php $form = \yii\bootstrap\ActiveForm::begin(['layout' => 'horizontal']); ?>
        
        <div class="col-lg-3 col-md-3">
            <?= $form->field($model, 'balance')->textInput([
                                'value'=>  number_format($user->getBalance(),2),
                                'readonly'=>true,
                                'style'=>'text-align:right;'
                        ]) ?>
        </div>
        
        <div class="col-lg-5 col-md-5">
            <?= $form->field($model, 'to_username')->textInput(['value'=>'']) ?>
        </div>
        
        <div class="col-lg-3 col-md-3">
            <?= $form->field($model, 'amount')->textInput(['value'=>'0.00','style'=>'text-align:right;']) ?>
        </div>
    
        <div class="col-lg-1 col-md-1 form-group">
            <?= yii\helpers\Html::submitButton('Transfer', ['class' =>'btn btn-primary']) ?>
        </div>
    
        <?= $form->field($model, 'dt')->hiddenInput(['value'=>time()])->label(false) ?>
        <?= $form->field($model, 'from_user_id')->hiddenInput(['value'=>$user->id])->label(false) ?>
        
        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
    

    <div class="body-content row">

        <div class="col-lg-12 col-md-12">
            
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $transactions,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width:50px;text-align:right;']
                    ],
                    'dt:dateTime',
                    'fromUsername',
                    'toUsername',
                    [
                        'attribute' => 'amount',
                        'value'=> function($model){
                            return number_format($model->amount, 2);
                        },
                        'contentOptions' => ['style' => 'width:120px;text-align:right;']
                    ]
                    
                ]
            ]); ?>
            
        </div>
       
    </div>
</div>
