<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Informacionpersonal;
use app\models\InformacionpersonalD;
use app\models\Personaldata;
use app\models\User;

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

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goHome();
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
        $cacheKey = 'user_' . Yii::$app->user->id;
        Yii::$app->cache->delete($cacheKey);
        
        Yii::$app->session->remove('selectBiblioteca');
        Yii::$app->session->remove('librarySelectionJSLoaded');

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


    public function actionGuardarBibliotecaEnSesion()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Verificar si se recibió la opción a guardar
        $selectedOption = Yii::$app->request->post('option');
        if ($selectedOption !== null) {
            // Guardar la opción en la sesión
            Yii::$app->session->set('selectBiblioteca', $selectedOption);

            // Enviar una respuesta JSON indicando éxito
            return ['success' => true];
        }

        // Enviar una respuesta JSON indicando error si no se recibió la opción
        return ['success' => false, 'error' => 'No se recibió la opción.'];
    }

    public function actionSignup()
    {
        $model = new Personaldata(); // Ajusta el modelo de Datos Personales según tu aplicación.

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {

                //Buscar datos ya existentes.
                $externo = Personaldata::findOne($model->Ci);

                if (!$externo ) {
                    if ($model->save) {
                        // Los datos personales se guardaron con éxito.
                        \Yii::$app->session->setFlash('success', 'Datos Registrados con éxito. Para la primera sesión, Usuario: CI, Contraseña: CI.');
                    } else {
                        // Si se envió el formulario pero no se cargaron ni guardaron datos, muestra un mensaje de error.
                        \Yii::$app->session->setFlash('error', 'Error al guardar los datos personales.');
                    }
                } elseif($externo) {
                    $usuario = User::find()->where(['username' => $model->Ci])->one();

                    if ($usuario->Status == 1) {
                        \Yii::$app->session->setFlash('info', 'Existe una cuenta activa con estos datos');
                    } elseif($usuario->Status == 0) {
                        \Yii::$app->session->setFlash('info', 'Existe una cuenta inactiva con estos datos. Para más información, comunicarse con administración.');
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        // Renderiza la vista de registro.
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
