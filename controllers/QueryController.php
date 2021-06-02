<?php

namespace app\controllers;

use app\models\Answer;
use Yii;
use app\models\Portrait;
use app\models\Query;
use app\models\QuerySearch;
use app\models\Users;
use DateTime;
use DateTimeZone;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QueryController implements the CRUD actions for Query model.
 */
class QueryController extends Controller
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
     * Lists all Query models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Query model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Query();
        $users_id = Yii::$app->user->id;
        $date_created = $this->formatDate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'users_id' => $users_id,
            'date_created' => $date_created,
        ]);
    }

    /**
     * Updates an existing Query model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $users_id = Yii::$app->user->id;
        $date_created = $this->formatDate();

        if ($this->findOwnQuery($id, $users_id)) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
    
            return $this->render('update', [
                'model' => $model,
                'users_id' => $users_id,
                'date_created' => $date_created,
            ]);
        }
        Yii::$app->session->setFlash('error', 'You can only update your own query.');
        return $this->redirect(['view', 'id' => $model->id]); 
    }

    /**
     * Deletes an existing Query model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $users_id = Yii::$app->user->id;

        if ($this->findOwnQuery($id, $users_id) || Yii::$app->user->identity->is_admin === true) {
            if ($this->findModel($id)->delete()) {
                Yii::$app->session->setFlash('success', 'Query has been successfully deleted.');
            } else {
                Yii::$app->session->setFlash('error', 'Query is associated with some answers.');
            }
            return $this->redirect(['index']);
        }
        Yii::$app->session->setFlash('error', 'You can only delete your own query.');
        return $this->redirect(['view', 'id' => $id]);    
    }

    /**
     * Finds the Query model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Query the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Query::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Portrait model based on its primary key value.
     * If the model is not found, a null.
     * @param integer $id
     * @return mixed Portrait || null
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
     * Finds the Query model based on its primary key value and users_id.
     * If the model is not found, a null.
     * @param integer $id && $users_id
     * @return mixed Query || null
     */
    protected function findOwnQuery($id, $users_id)
    {
        if (($model = Query::find()
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
     * Formats UTC dateTime to Europe dateTime
     * @param integer string
     * @return mixed string
     */
    protected function formatDate()
    {
        $date_created = date('Y-m-d H:i:s');
        $dt = new DateTime($date_created, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('Europe/Madrid'));
        $dt = $dt->format('d-m-Y H:i:s');

        return $dt;
    }
}
