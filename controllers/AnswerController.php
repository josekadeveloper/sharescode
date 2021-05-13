<?php

namespace app\controllers;

use Yii;
use app\models\Answer;
use app\models\AnswerSearch;
use app\models\Portrait;
use app\models\Query;
use app\models\Reminder;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $user_id = Yii::$app->user->id;
                            $portrait = $this->findPortrait($user_id);
                            if ($portrait !== null) {
                                $portrait_id = $portrait->id;
                            } else {
                                $portrait_id = null;
                                return $this->redirect(['portrait/create', 'id' => $user_id]);
                            }
                            return $portrait_id !== null;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Answer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnswerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Answer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Answer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if (Yii::$app->request->isAjax) {

            $users_id = Yii::$app->user->id;
            $model_portrait = $this->findPortrait($users_id);
            $username = $model_portrait->nickname;
            $img = Portrait::devolverImg($model_portrait);
            $urlPortrait = Url::toRoute(['portrait/view', 'id' => $users_id]);
            $date_created = date('Y-m-d H:i:s');
            $content = Yii::$app->request->post('content');
            $sending_user_id = Query::findOne(['id' => $id])['users_id'];

            $model = new Answer([
                'content' => $content,
                'date_created' => $date_created,
                'query_id' => $id,
                'users_id' => $users_id,
            ]);

            $model->save();
            $this->createReminder($id, $sending_user_id);
            $this->sendReminder($id, $sending_user_id);
            
            return $this->asJson([
                'response' => $this->builderResponse($img, $urlPortrait, $username, $date_created, $content),
            ]);
        }
    }

    /**
     * Updates an existing Answer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $users_id = Yii::$app->user->id;
        $query_id = Answer::find()->where(['id' => $id])->one()['query_id'];
        $sending_user_id = Query::findOne(['id' => $query_id])['users_id'];
        $urlAnswer = Url::toRoute(['query/view', 'id' => $query_id]);

        if ($this->findOwnAnswer($id, $users_id)) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->createReminder($query_id, $sending_user_id);
                $this->sendReminder($id, $sending_user_id);
                Yii::$app->session->setFlash('success', 'Answer has been modified successfully.');
                return $this->redirect($urlAnswer);
            }
    
            return $this->render('update', [
                'model' => $model,
                'query_id' => $query_id,
                'users_id' => $users_id,
            ]);
        }
        Yii::$app->session->setFlash('error', 'You can only update your own answer.');
        return $this->redirect($urlAnswer); 
    }

    /**
     * Deletes an existing Answer model.
     * If deletion is successful, the browser will be redirected to the 'query/view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $users_id = Yii::$app->user->id;
        $query_id = Answer::find()->where(['id' => $id])->one()['query_id'];
        $urlAnswer = Url::toRoute(['query/view', 'id' => $query_id]);
        if ($this->findOwnAnswer($id, $users_id) || Yii::$app->user->identity->is_admin === true) {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', 'Answer has been successfully deleted.');
            }
            return $this->redirect($urlAnswer);   
        }
        Yii::$app->session->setFlash('error', 'You can only delete your own answer.');
        return $this->redirect($urlAnswer);  
    }

    /**
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Portrait model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Portrait the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPortrait($id)
    {
        if (($model = Portrait::find()
                        ->where(['id' => $id])
                        ->one()) !== null
            ) {
            return $model;
        }
        return null;
    }

    /**
     * Finds the Answer model based on its primary key value and users_id.
     * If the model is not found, a null.
     * @param integer $id && $users_id
     * @return mixed Answer || null
     */
    protected function findOwnAnswer($id, $users_id)
    {
        if (($model = Answer::find()
                        ->where([
                            'id' => $id,
                            'users_id' => $users_id,
                      ])->one()) !== null
            ){
            return $model;
        }
        return null;
    }

    /**
     *  A reminder will be created when creating or 
     * modifying an answer referring to a query
     * @param integer $query_id && $users_id
     */
    protected function createReminder($query_id, $users_id)
    {
        $name_query = Query::findOne(['id' => $query_id])['title'];
        $reminder = new Reminder(['title' => 'Se ha respondido a una de tus consultas', 
                                  'dispatch' => "Se ha respondido a la consulta $name_query",
                                  'users_id' => $users_id]);
        $reminder->save();
    }

    /**
     *  The user will be notified by email that they 
     * have received a reminder
     * @param integer $query_id && $users_id
     */
    protected function sendReminder($query_id, $users_id)
    {
        $model = Portrait::findOne(['id' => $users_id]);
        $body = 'To see your notifications click here: '
            . Html::a (
                'View notifications',
                Url::to([
                    'query/view',
                    'id' => $query_id,
                ], true)
            );
        Yii::$app->mailer->compose()
            ->setTo($model->email)
            ->setFrom(Yii::$app->params['smtpUsername'])
            ->setSubject('View reminder')
            ->setHtmlBody($body)
            ->send();
    }

    /**
     *  Create the response as html container 
     * to integrate it into the view
     */
    public function builderResponse($img, $urlPortrait, $username, $date_created, $content)
    {
        if (Yii::$app->user->isGuest) {
            return '';
        } else {
            return
            '<div class="card-footer card-comments">' .
                    '<div class="card-comment">'.
                        '<div class="img-circle" alt="User Image">'.
                            $img .
                        '</div>'.
                        '<div class="comment-text">'.
                            '<span class="username">'.
                                '<a href=' . $urlPortrait . '>' .
                                    $username .
                                '</a>' .
                                '<span class="text-muted float-right">'.
                                    $date_created .
                                '</span>'.
                            '</span>'.
                            $content .
                        '</div>'.
                        '<hr>'.
                        '<button type="button" class="btn btn-default btn-sm">'.
                            '<i class="fas fa-share">' .
                            '</i>' .
                            ' Share' .
                        '</button>' .
                        '<button type="button" class="btn btn-default btn-sm">'.
                            '<i class="far fa-thumbs-up">' .
                            '</i>' .
                            ' Like' .
                            '</button>' .
                        '<span class="float-right text-muted">' .
                            '45 likes - 2 comments' .
                        '</span>' .
                    '</div>' .
            '</div>';
        }
    }
}
