<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $messageForm \app\models\MessageAddForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $message): ?>
            <?= $this->render('_list-message', compact('message')) ?>
        <?php endforeach; ?>

        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    <?php else: ?>
        <div class="form-group">Нет сообщений</div>
    <?php endif; ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="message-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($messageForm,
                'message')->textarea(['rows' => 6])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить',
                    ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    <?php endif; ?>
</div>
