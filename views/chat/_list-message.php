<?php
/* @var $message app\models\Message */

use yii\helpers\Html;

if ($message->isRejected()) {
    $panelClass = 'panel-warning';
} else {
    $panelClass = $message->user->isAdmin() ? 'panel-primary' : 'panel-default';
}

$moderationLink = null;
if (Yii::$app->user->identity && Yii::$app->user->getIdentity()->isAdmin() && $message->isApproved()) {
    $moderationLink = Html::a('Отклонить',
        ['chat/reject', 'id' => $message->id],
        ['class' => 'btn btn-danger btn-reject']);
}
?>

<div class="panel <?= $panelClass ?>">
    <div class="panel-heading">
        <?= $moderationLink ?>
        <div>
            <strong>Отправитель:</strong> <?= Html::encode($message->user->username) ?>
        </div>
        <div><strong>Дата:</strong> <?= $message->date ?></div>
    </div>
    <div class="panel-body">
        <?= Html::encode($message->message) ?>
    </div>
</div>
