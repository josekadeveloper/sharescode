<?php

namespace app\controllers;

use app\models\Assessment;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Portrait;
use app\models\Users;
use app\models\Votes;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $model_portrait = Portrait::findOne(['nickname' => $model->username]);
            if ($model_portrait === null || !$model_portrait->validatePassword($model->password)) {
                Users::builderAlert('error', 'Error', 'Data entered is incorrect.');
            }
            if ($model_portrait !== null) {
                $portrait_id = Portrait::findOne(['nickname' => $model->username])['id'];
                $model_portrait = Users::findOne(['id' => $portrait_id]);

                if ($model->login()) {
                    return $this->goBack();
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     *  Logout action.
     *  If the user is less than one day old at the end of the session,
     * they will be given a questionnaire in order to improve the website.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $antiquity = Users::getAntiquity(Yii::$app->user->id);
        $antiquity = substr($antiquity, 0, 2);
        $old_assessment = 0.0;

        if (Assessment::find()->all() !== null) {
            foreach (Assessment::find()->all() as $key) {
                $old_assessment = $key->total_percent;
            }
        }
        
        if ($antiquity === '00') {
            $model = new Votes();
            if ($model->load(Yii::$app->request->post())) {
                $vote_type = $model->typ;
                switch ($vote_type) {
                    case 'wrong':
                        $vote = -1;
                        break;
                    case 'regular':
                        $vote = 1;
                        break;
                    case 'good':
                        $vote = 2;
                        break;
                    case 'very good':
                        $vote = 3;
                        break;
                }
                $model->typ = $vote_type;
                $model->puntuation = $vote;
                $model->users_id = Yii::$app->user->id;

                if ($model->save()) {
                    $assessment = new Assessment();
                    $num_votes = Votes::find()->count();
                    $puntuation_total = [];
                    foreach (Votes::find()->all() as $key) {
                        foreach ($key as $k => $v) {
                            if ($k === 'puntuation') {
                                $v = intval($v);
                                array_push($puntuation_total, $v);
                            }
                        }
                    }
                    $puntuation_total = array_sum($puntuation_total);
                    $puntuation_perfect = $num_votes * 3;
                    $percent = (100 * $puntuation_total) / $puntuation_perfect;
                    $percent = round($percent, 2);
                    $assessment->total_percent = $percent;
                    $assessment->votes_id = $model->id;
                    
                    foreach (Assessment::find()->all() as $key) {
                        $key->delete();
                    }
                    if ($assessment->save()) {
                        Yii::$app->user->logout();

                        return $this->goHome();
                    }
                }
            }
            return $this->render('assessment', [
                'model' => $model,
                'old_assessment' => intval($old_assessment),
            ]);
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
