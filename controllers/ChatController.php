<?php

namespace app\controllers;

use app\models\Message;
use app\models\MessageAddForm;
use app\models\MessageSearch;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ChatController implements the CRUD actions for Message model.
 */
class ChatController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'verbs' => ['GET'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['reject', 'rejected-list', 'approve'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->getIdentity()->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Message::find()->with(['user']);
        if (Yii::$app->user->isGuest || Yii::$app->user->getIdentity()->isUser()) {
            $query->where(['status' => Message::MESSAGE_APPROVED]);
        }
        $query->orderBy('date DESC');

        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 10
        ]);
        $messages = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if ($messages) {
            usort($messages, function ($a, $b) {
                return strcmp($a->date, $b->date);
            });
        }

        $messageForm = new MessageAddForm();

        if ($messageForm->load(Yii::$app->request->post()) && $messageForm->validate()) {
            $message = new Message();
            $message->user_id = Yii::$app->user->id;
            $message->date = date('Y-m-d H:i:s', time());
            $message->message = $messageForm->message;
            $message->save(false);

            return $this->redirect(['index']);
        }

        return $this->render('index',
            compact('messages', 'pages', 'messageForm'));
    }

    public function actionReject($id)
    {
        $message = $this->findModel($id);

        $message->status = Message::MESSAGE_REJECTED;
        $message->save(false);

        return $this->goBack();
    }

    public function actionRejectedList()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('rejected-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApprove($id)
    {
        $message = $this->findModel($id);

        $message->status = Message::MESSAGE_APPROVED;
        $message->save(false);

        return $this->redirect('rejected-list');
    }

    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
