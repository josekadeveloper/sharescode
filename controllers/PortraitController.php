<?php

namespace app\controllers;

use Yii;
use app\models\Portrait;
use app\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PortraitController implements the CRUD actions for Portrait model.
 */
class PortraitController extends Controller
{
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
     * Displays a single Portrait model.
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
