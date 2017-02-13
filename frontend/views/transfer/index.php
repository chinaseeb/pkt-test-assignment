<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
