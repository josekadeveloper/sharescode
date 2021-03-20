<?php

namespace app\controllers;

use Yii;
use app\models\Portrait;
use app\models\Users;
use yii\bootstrap4\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        $model = new Portrait();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['portrait/index', 'id' => $model->id]);
        }

        $usu_id = Yii::$app->user->identity->id;

        $model2 = Portrait::find()->where(['us_id' => $usu_id])->one();

        $nickname = Users::find()->where(['id' => $usu_id])->one()->getAttributes()['nickname'];
        return $this->render('index', [
            'model' => $model,
            'model2' => $model2,
            'nickname' => $nickname,
        ]);
        
        return $this->redirect(['site/login']); 
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
