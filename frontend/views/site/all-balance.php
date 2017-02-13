<?php 

/* @var $this yii\web\View */


$this->title = 'All Balance';

?>

<div class="body-content row">

        <div class="col-lg-12 col-md-12">
            
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width:50px;text-align:right;']
                    ],
                    'username',
                    [
                        'attribute' => 'balance',
                        'value'=> function($model){
                            return number_format($model->balance, 2);
                        },
                        'contentOptions' => ['style' => 'width:120px;text-align:right;']
                    ]
                ]
            ]); ?>
            
        </div>
       
    </div>