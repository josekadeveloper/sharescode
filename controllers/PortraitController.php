<?php

namespace app\controllers;

use Yii;
use app\models\Portrait;
use app\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PortraitController implements the CRUD actions for Portrait model.
 */
class PortraitController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
     * Lists all Portrait models.
     * @return mixed
     */
    public function actionIndex()
    { 
        $usu_id = Yii::$app->user->identity->id;
        $model = Portrait::find()->where(['us_id' => $usu_id])->one();
        $nickname = Users::find()->where(['id' => $usu_id])->one()->nickname;

        if ($model === null) {
            return $this->redirect(['create']);
        } else {
            return $this->render('index', [
                'model' => $model,
                'nickname' => $nickname,
            ]);
        }
    }

    /**
     * Create a new Portrait model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Portrait();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Portrait model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nickname = Users::find()->where(['id' => $model->us_id])->one()->nickname;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Portrait model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $nickname = Users::find()->where(['id' => $model->us_id])->one()->nickname;

        return $this->render('view', [
            'model' => $model,
            'nickname' => $nickname,
        ]);
    }

    /**
     * Deletes an existing Portrait model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'El perfil se ha borrado correctamente.');
        }
        return $this->redirect(['portrait/index']); 
    }

    /**
     * Finds the Portrait model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Portrait the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Portrait::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
