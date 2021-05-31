<?php

namespace app\controllers;

use app\models\Prestige;
use app\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PrestigeController implements the CRUD actions for Prestige model.
 */
class PrestigeController extends Controller
{
    /**
     * Displays a single Prestige model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $antiquity = Users::getAntiquity($model->users_id);
        return $this->render('view', [
            'model' => $model,
            'antiquity' => $antiquity,
        ]);
    }

    /**
     * Finds the Prestige model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prestige the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prestige::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
