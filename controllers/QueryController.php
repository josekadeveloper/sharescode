<?php

namespace app\controllers;

use Yii;
use app\models\Portrait;
use app\models\Query;
use app\models\QuerySearch;
use app\models\Reminder;
use app\models\Users;
use DateTime;
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

        if ($model->load(Yii::$app->request->post())) {
            $model->explanation = $this->changeToHtml($model->explanation);
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'users_id' => $users_id,
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
        $model->explanation = $this->changeToTextPlain($model->explanation);
        $users_id = Yii::$app->user->id;

        if ($this->findOwnQuery($id, $users_id) || Yii::$app->user->identity->is_admin === true) {
            if ($model->load(Yii::$app->request->post())) {
                $model->explanation = str_replace("\n", '<br>', $model->explanation);
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
    
            return $this->render('update', [
                'model' => $model,
                'users_id' => $users_id,
            ]);
        }
        return $this->redirect(['index']);
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
        $model = $this->findModel($id);
        $dispatch = 'Se ha respondido a la consulta ' . $model->title;
        $models_reminder = Reminder::find()->where([
            'dispatch' => $dispatch,
        ])->all();
        if ($this->findOwnQuery($id, $users_id) || Yii::$app->user->identity->is_admin === true) {
            if ($model->delete()) {
                foreach ($models_reminder as $mod) {
                    $mod->delete();
                }
            } else {
                Users::builderAlert('error', 'Error', 'Query is associated with some answers.');
            }
        }
        return $this->redirect(['index']);
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
            ) {
            return $model;
        }
        return null;
    }

    /**
     * Change plain text to Html code
     *
     * @return string
     */
    public function changeToHtml($content)
    {
        $content = str_replace(' ', '&nbsp', $content);
        $content = str_replace('>', '&gt', $content);
        $content = str_replace('<', '&lt', $content);
        $content = str_replace("\n", '<br>', $content);
        return $content;
    }

    /**
     * Change Html code to plain text
     *
     * @return string
     */
    public function changeToTextPlain($content)
    {
        $content = str_replace('<br>', "\n", $content);
        $content = str_replace('&nbsp', ' ', $content);
        $content = str_replace('&gt', '>', $content);
        $content = str_replace('&lt', '<', $content);
        return $content;
    }
}
