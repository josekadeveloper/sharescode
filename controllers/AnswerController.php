<?php

namespace app\controllers;

use Yii;
use app\models\Answer;
use app\models\AnswerSearch;
use app\models\Portrait;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $model = new Answer();
        $portrait = $this->findPortrait(Yii::$app->user->id);
        $portrait_id = $portrait->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'id' => $id,
            'portrait_id' => $portrait_id,
        ]);
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
        $portrait = $this->findPortrait(Yii::$app->user->id);
        $portrait_id = $portrait->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'id' => $id,
            'portrait_id' => $portrait_id,
        ]);
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
        $query_id = Answer::find()->where(['id' => $id])->one()['query_id'];
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Answer has been successfully deleted.');
        }
        $urlAnswer = Url::toRoute(['query/view', 'id' => $query_id]);
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
                        ->where(['us_id' => $id])
                        ->one()) !== null
            ) {
            return $model;
        }
        throw new NotFoundHttpException('To carry out the action, a profile must be created on this website.');
    }
}
