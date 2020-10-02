<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rejected List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'message',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{approve}',
                'buttons' => [
                    'approve' => function (
                        $url,
                        $model,
                        $key
                    ) {
                        return Html::a('Одобрить',
                            ['chat/approve', 'id' => $model->id],
                            ['class' => 'btn btn-success']);
                    }
                ]
            ]
        ],
    ]); ?>


</div>
