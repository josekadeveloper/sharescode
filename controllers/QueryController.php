<?php

namespace app\controllers;

use app\models\Answer;
use Yii;
use app\models\Portrait;
use app\models\Query;
use app\models\QuerySearch;
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
     * Displays a single Query model.
     * If the user is logged, he has created a profile and is 
     * the creator of the query, he can modify or delete it
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if ($this->findPortrait(Yii::$app->user->id)) {
            $portrait_id = $this->findPortrait(Yii::$app->user->id)->id;
            if ($this->findOwnQuery($id, $portrait_id)) {
                $owner_id = $portrait_id;
            } else {
                $owner_id = null;
            }
        } else {
            $owner_id = null;
        }

        $query = Answer::find()->where(['query_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'owner_id' => $owner_id,
            'name_portrait' => Portrait::find()
                                ->where(['id' => $this->findModel($id)->portrait_id])
                                ->one()['name_portrait'],
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
        $portrait = $this->findPortrait(Yii::$app->user->id);

        if ($portrait !== null) {
            $portrait_id = $portrait->id;
        } else {
            $portrait_id = null;
        }
  
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'portrait_id' => $portrait_id,
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
        $portrait = $this->findPortrait(Yii::$app->user->id);

        if ($portrait !== null) {
            $portrait_id = $portrait->id;
        } else {
            $portrait_id = null;
        }

        if ($this->findOwnQuery($id, $portrait_id)) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
    
            return $this->render('update', [
                'model' => $model,
                'portrait_id' => $portrait_id,
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
        $portrait = $this->findPortrait(Yii::$app->user->id);

        if ($portrait !== null) {
            $portrait_id = $portrait->id;
        } else {
            $portrait_id = null;
        }

        if ($this->findOwnQuery($id, $portrait_id)) {
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
                        ->where(['us_id' => $id])
                        ->one()) !== null
            ) {
            return $model;
        }
        return null;
    }

    /**
     * Finds the Query model based on its primary key value and portrait_id.
     * If the model is not found, a null.
     * @param integer $id && $portrait_id
     * @return mixed Query || null
     */
    protected function findOwnQuery($id, $portrait_id)
    {
        if (($model = Query::find()
                        ->where([
                            'id' => $id,
                            'portrait_id' => $portrait_id,
                      ])->one()) !== null
            ){
            return $model;
        }
        return null;
    }
}
