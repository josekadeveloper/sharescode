<?php

namespace app\controllers;

use app\models\Assessment;
use Yii;
use app\models\Votes;
use app\models\VotesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * VotesController implements the CRUD actions for Votes model.
 */
class VotesController extends Controller
{
    /**
     * Lists all Votes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VotesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Assessment::find()->all() !== null) {
            foreach (Assessment::find()->all() as $key) {
                $old_assessment = $key->total_percent;
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'old_assessment' => $old_assessment,
        ]);
    }

    /**
     * Displays a single Votes model.
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
     * Finds the Votes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Votes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Votes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
