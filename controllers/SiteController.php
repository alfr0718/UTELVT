<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Personaldata as PersonalD;
use app\models\Usuario as Usuario;
use app\models\Libro as Libro;
use app\models\Prestamo as Prestamo;

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
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


    public function actionSignUp()
    {
        $PersonalD = new Personaldata(); // Ajusta el modelo de Datos Personales según tu aplicación.
        $User = new User(); // Ajusta el modelo de Usuario según tu aplicación.

        if ($PersonalD->load(Yii::$app->request->post()) && $PersonalD->save()) {
            // Los datos personales se guardaron con éxito, ahora puedes crear un usuario.
            // Puedes utilizar los datos personales para llenar el modelo de Usuario si es necesario.
            $User->username = $PersonalD->Ci;
            $User->password = $PersonalD->Ci;

            // Aquí puedes configurar otros campos del modelo Usuario según tus necesidades.

            if ($User->save()) {
                // El usuario se creó con éxito.
                \Yii::$app->session->setFlash('success', 'Datos personales y usuario creados con éxito.');
            } else {
                \Yii::$app->session->setFlash('error', 'Error al crear el usuario.');
            }
        } else {
            \Yii::$app->session->setFlash('error', 'Error al guardar los datos personales.');
        }

        // Redirige a donde sea necesario después de completar las acciones.
        return $this->render('view-generated-data', [
            'PersonalD' => $PersonalD,  // Pasa el modelo de datos personales si deseas mostrarlo en la vista.
            'User' => $User,    // Pasa el modelo de usuario si deseas mostrarlo en la vista.
        ]);
    // Ajusta la redirección según tus necesidades.
    }

}
