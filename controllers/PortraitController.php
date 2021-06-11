<?php

namespace app\controllers;

use app\models\EmailRecoveryForm;
use app\models\NotRegistered;
use Yii;
use app\models\Portrait;
use app\models\PortraitSearch;
use app\models\Prestige;
use app\models\Users;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;

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
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
        $searchModel = new PortraitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create a new Portrait model.
     * If creation is successful, the browser will be redirected to the 'portrait' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Portrait(['scenario' => Portrait::SCENARIO_CREATE]);
        if ($model->load(Yii::$app->request->post())) {
            $model_user = $this->createUser();
            $model->id = $model_user->id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model_user->delete() ? Users::builderAlert('error', 'Error', 'Data incorrect') : '';
            } 
        }
        return $this->render('create', [
            'model' => $model,
        ]); 
    }

    /**
     * Register a Portrait.
     * If registration is successful, the browser will be redirected to the 'portrait' page.
     * @return mixed
     */
    public function actionRegister()
    {
        $model = new Portrait(['scenario' => Portrait::SCENARIO_REGISTER]);
        if ($model->load(Yii::$app->request->post())) {
            $model_user = $this->createUser();
            $model->id = $model_user->id;
            if ($model->save()) {
                $notRegistered = new NotRegistered([
                    'id' => $model->id,
                    'token' => Yii::$app->security->generateRandomString(),
                ]);
                $notRegistered->save();
                $this->sendEmail($model, $notRegistered);
                Users::builderAlert('success', 'Success', 'You must activate your user from the email sent.');
            } else {
                $model_user->delete() ? Users::builderAlert('error', 'Error', 'Data incorrect') : '';
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);     
    }

    public function actionActivate($id, $token)
    {
        $user = $this->findModel($id);
        if ($user->notRegistered === null) {
            return $this->goHome();
        }
        if ($user->notRegistered->token === $token) {
            $user->notRegistered->delete();
            return $this->redirect(Yii::$app->user->loginUrl);
        }
        Users::builderAlert('error', 'Error', "$token");
        return $this->goHome();
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
        $model->scenario = Portrait::SCENARIO_UPDATE;
        $model->password = '';
        $user_portrait = Portrait::find()->where(['id' => Yii::$app->user->id])->one()['id'];

        if ($id == $user_portrait || Yii::$app->user->identity->is_admin === true) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]); 
            }
    
            return $this->render('update', [
                'model' => $model,
                'id' => $id,
            ]);
        }
        return $this->redirect(['query/index']);
    }

    /**
     * Displays a single Portrait model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model_user = Users::findOne(['id' => $id]);
        if ($model_user->is_deleted === true) {
            Users::builderAlert('error', 'Error', 'User has been deleted.');
            return $this->redirect(['/query/index']);
        }
        if (Yii::$app->user->id !== null) {
            if (Portrait::find()->where(['id' => Yii::$app->user->id])->one() !== null) {
                $user_id = Portrait::find()->where(['id' => Yii::$app->user->id])->one()['id'];
            } else {
                $user_id = null;
            }
        } else {
            $user_id = null;
        }
        $model = $this->findModel($id);
        $model_portrait = Portrait::findOne(['id' => Yii::$app->user->id]);

        return $this->render('view', [
            'model' => $model,
            'model_portrait' => $model_portrait,
            'user_id' => $user_id,
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
        $portrait_id = Portrait::find()->where(['id' => $id])->one()['id'];
        if ($id == $portrait_id || Yii::$app->user->identity->is_admin === true) {
            $model_user = Users::findOne(['id' => $portrait_id]);
            $model_user->is_deleted = true;
            $model_user->save();
            $model_portrait = $this->findModel($id);
            $model_portrait->delete();
            return $this->redirect(['/query/index']);
        }
        return $this->redirect(['view', 'id' => $id]); 
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

    /**
     * Register a User.
     */
    private function createUser() {
        $model = new Users();
        $model->save();
        $this->createPrestige($model->id);
        return $model;
    }

    /**
     * Create a Prestige of the User.
     */
    private function createPrestige($users_id) {
        $model = new Prestige([
            'puntuation' => 0,
            'type_prestige_id' => 1,
            'users_id' => $users_id,
        ]);
        $model->save();
    }

    /**
     * Searches the database if there is a registered user with the same nickname
     *
     * @param string $nickname
     * @return Object Json
     */
    public function actionLookingForNicknameAjax($nickname)
    {
        if (Yii::$app->request->isAjax) {
            $portrait = Portrait::findOne(['nickname' => $nickname]);
            if ($portrait === null) {
                return $this->asJson(['find' => false]);
            }
            return $this->asJson([
                'find' => true,
                'nickname' => $portrait->nickname,
            ]);
        }
    }

    /**
     * Searches the database if there is a registered user with the same e-mail
     *
     * @param string $email
     * @return Object Json
     */
    public function actionLookingForEmailAjax($email)
    {
        if (Yii::$app->request->isAjax) {
            $portrait = Portrait::findOne(['email' => $email]);
            if ($portrait === null) {
                return $this->asJson(['find' => false]);
            }
            return $this->asJson([
                'find' => true,
                'email' => $portrait->email,
            ]);
        }
    }

    /**
     * Searches the database if there is a registered user with the same repository
     *
     * @param string $repository
     * @return Object Json
     */
    public function actionLookingForRepositoryAjax($repository)
    {
        if (Yii::$app->request->isAjax) {
            $portrait = Portrait::findOne(['repository' => $repository]);
            if ($portrait === null) {
                return $this->asJson(['find' => false]);
            }
            return $this->asJson([
                'find' => true,
                'repository' => $portrait->repository,
            ]);
        }
    }

    /**
     * Render a form to reset a user password.
     * @param  string $token The user password token
     * @return mixed
     */
    public function actionRestorePass($token)
    {
        if (($model = Portrait::findOne(['token_pass' => $token])) === null) {
            return $this->goHome();
        }

        $model->scenario = Portrait::SCENARIO_RECOVERY;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->token_pass = null;
            $model->save();
            Users::builderAlert('success', 'Success', 'Your password has been changed correctly');
        }
        $model->password = '';

        return $this->render('recovery', [
            'model' => $model,
        ]);
    }

    /**
     * Send an email to the user who has requested to recover their password.
     * @return mixed
     */
    public function actionRecoveryPass()
    {
        $form = new EmailRecoveryForm();
        $email = Yii::$app->request->post('email');
        if ($email !== null) {
            $form->email = $email;
            if ($form->validate()) {
                $token = Yii::$app->security->generateRandomString();
                $model = Portrait::findOne(['email' => $email]);
                $model->token_pass = $token;
                if ($model->save()) {
                    $this->sendEmail($model, $token, true);
                    Users::builderAlert('info', 'Info', 'You will receive an email with instructions to reset your password.');
                }
            } else {
                Users::builderAlert('error', 'Error', 'Email does not exist');
            }
        }

        return $this->render('recovery-email', [
            'model' => $form,
        ]);
    }

    /**
     * Send a confirmation email to the user who registers.
     * @param  Portrait $model The user to whom the email is sent
     * @param mixed $recover True if the email is password recovery
     * @return bool               returns true if it has been sent successfully,
     *                            false otherwise                      
     */
    public function sendEmail($model, $notRegistered, $recover = false)
    {
        if ($recover) {
            $title = 'Password reset';
            $content = 'You have requested a password change';
            $link = Html::a('Modify password', Url::to([
                    'portrait/restore-pass',
                    'token' => $notRegistered,
                ], true));
        } else {
            $title = 'Account validation';
            $content = 'You have successfully registered in <strong>Sharecode</strong>';
            $link = Html::a(
                'Click here to activate your account',
                Url::to([
                    'portrait/activate',
                    'id' => $model->id,
                    'token' => $notRegistered->token
                ], true)
            );
        }
        $header = "Welcome to Sharecode!!!";
        $body = "¡Hello $model->nickname!<br>$content.<br><br>$link";
        return Yii::$app->mailer->compose('template', [
            'user' => $model,
            'header' => $header,
            'body' => $body,
        ])
        ->setFrom(Yii::$app->params['adminEmail'])
        ->setTo($model->email)
        ->setSubject($title)
        ->send();
    }

}
