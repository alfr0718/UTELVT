<?php

namespace app\controllers;

use app\models\Ejemplar;
use app\models\EjemplarSearch;
use app\models\Informacionpersonal;
use app\models\InformacionpersonalD;
use app\models\Libro;
use app\models\Pc;
use app\models\Personaldata;
use app\models\Prestamo;
use app\models\User;
use ChangeStatusJob;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * SolicitudController implements the las acciones de prestamos de servicios.
 */
class SolicitudController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndiceEjemplares($id)
    {
        // Cargar el modelo de libro basado en el $id recibido
        $Libro = Libro::findOne(['id' => $id]);

        // Verificar si el libro existe
        if (!$Libro) {
            throw new NotFoundHttpException('El libro no se encontró.');
        }

        $searchModel = new EjemplarSearch();
        $searchModel->libro_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('indexEjemplar/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSolicitarLibro($id)
    {
        $isEnabled = false;

        // Cargar el modelo de libro basado en el $id recibido
        $ejemplar = Ejemplar::findOne(['id' => $id]);

        // Verificar si el libro existe
        if (!$ejemplar) {
            throw new NotFoundHttpException('El libro no se encontró.');
        }

        $model = new Prestamo();

        $model->tipoprestamo_id = 'LIB';
        $model->biblioteca_idbiblioteca = $ejemplar->biblioteca_idbiblioteca;
        $model->object_id = $id;

        if (!Yii::$app->user->isGuest) {
            // Accede a los datos del usuario actualmente autenticado
            $userData = Yii::$app->user->identity;
            if ($userData->tipo_usuario === User::TYPE_EXTERNO || $userData->tipo_usuario === User::TYPE_ESTUDIANTE || $userData->tipo_usuario === USER::TYPE_DOCENTE) {
                $model->cedula_solicitante = $userData->username;
                $isEnabled = true;
            }
        }


        if ($this->request->isPost) {
            // Verificar si se envió un formulario
            if ($model->load(\Yii::$app->request->post())) {

                $personalU = InformacionpersonalD::find()->where(['CIInfPer' => $model->cedula_solicitante])->one();
                $estudiante = Informacionpersonal::find()->where(['CIInfPer' => $model->cedula_solicitante])->one();
                $externo = Personaldata::find()->where(['Ci' => $model->cedula_solicitante])->one();

                // Verifica qué relación no es nula y asigna la cédula correspondiente
                if ($personalU !== null) {
                    $model->informacionpersonal_d_CIInfPer = $personalU->CIInfPer;
                } elseif ($estudiante !== null) {
                    $model->informacionpersonal_CIInfPer = $estudiante->CIInfPer;
                } elseif ($externo !== null) {
                    $model->personaldata_Ci = $externo->Ci;
                }

                if ($personalU == null && $estudiante == null && $externo == null) {
                    Yii::$app->session->setFlash('error', 'No existe el solicitante en el sistema.');
                    return $this->redirect(Url::to(['site/error']));
                }

                // Asignar valores y calcular la fecha de entrega
                list($horas, $minutos) = explode(':', $model->intervalo_solicitado);


                $fechaSolicitud = new \DateTime($model->fecha_solicitud);
                $model->fecha_solicitud = Yii::$app->formatter->asDatetime($fechaSolicitud, 'yyyy-MM-dd HH:mm:ss');
                $intervalo = new \DateInterval('PT' . $horas . 'H' . $minutos . 'M'); // PT horas minutos
                $fechaEntrega = $fechaSolicitud->add($intervalo);
                $model->fechaentrega = Yii::$app->formatter->asDatetime($fechaEntrega, 'yyyy-MM-dd HH:mm:ss');

                // Verificar si el modelo se guarda con éxito
                if ($model->save()) {

                    $ejemplar->Status=2;
                    $ejemplar->save();
                    
                    Yii::$app->session->setFlash('success', 'Hemos recibido tu solicitud');
                    return $this->redirect(['prestamo/view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                } else {
                    Yii::$app->session->setFlash('error', 'No se pudo realizar la solicitud.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('solicitar-libro', [
            'model' => $model,
            'isEnabled' => $isEnabled,
        ]);
    }


    public function actionSolicitarEquipo($id)
    {
        $isEnabled = false;

        $equipo = Pc::find()->where(['idpc' => $id])->one();

        // Verificar si el computador existe
        if (!$equipo) {
            throw new NotFoundHttpException('El equipo no se encontró.');
        }


        $model = new Prestamo();
        $model->tipoprestamo_id = 'COMP';

        $model->biblioteca_idbiblioteca = $equipo->biblioteca_idbiblioteca; // Campus donde se encuentra el usuario... mejorar (Y)
        $model->object_id = $id;

        if (!Yii::$app->user->isGuest) {
            // Accede a los datos del usuario actualmente autenticado
            $userData = Yii::$app->user->identity;
            if ($userData->tipo_usuario === User::TYPE_EXTERNO || $userData->tipo_usuario === User::TYPE_ESTUDIANTE || $userData->tipo_usuario === USER::TYPE_DOCENTE) {
                $model->cedula_solicitante = $userData->username;
                $isEnabled = true;
            }
        }


        if ($this->request->isPost) {

            if ($model->load(\Yii::$app->request->post())) {

                $personalU = InformacionpersonalD::find()->where(['CIInfPer' => $model->cedula_solicitante])->one();
                $estudiante = Informacionpersonal::find()->where(['CIInfPer' => $model->cedula_solicitante])->one();
                $externo = Personaldata::find()->where(['Ci' => $model->cedula_solicitante])->one();

                // Verifica qué relación no es nula y asigna la cédula correspondiente
                if ($personalU !== null) {
                    $model->informacionpersonal_d_CIInfPer = $personalU->CIInfPer;
                } elseif ($estudiante !== null) {
                    $model->informacionpersonal_CIInfPer = $estudiante->CIInfPer;
                } elseif ($externo !== null) {
                    $model->personaldata_Ci = $externo->Ci;
                }

                if ($personalU == null && $estudiante == null && $externo == null) {
                    Yii::$app->session->setFlash('error', 'No existe el solicitante en el sistema.');
                    return $this->redirect(Url::to(['site/error']));
                }

                // Asignar valores y calcular la fecha de entrega
                list($horas, $minutos) = explode(':', $model->intervalo_solicitado);

                $fechaSolicitud = new \DateTime($model->fecha_solicitud);
                $model->fecha_solicitud = Yii::$app->formatter->asDatetime($fechaSolicitud, 'yyyy-MM-dd HH:mm:ss');
                $intervalo = new \DateInterval('PT' . $horas . 'H' . $minutos . 'M'); // PT horas minutos
                $fechaEntrega = $fechaSolicitud->add($intervalo);
                $model->fechaentrega = Yii::$app->formatter->asDatetime($fechaEntrega, 'yyyy-MM-dd HH:mm:ss');
                // Verificar si el modelo se guarda con éxito
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Hemos recibido tu solicitud');
                    $equipo->Status = 2;
                    $equipo->save();
                    return $this->redirect(['prestamo/view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                } else {
                    Yii::$app->session->setFlash('error', 'No se pudo realizar la solicitud.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->renderAjax('solicitar-equipo', [
            'model' => $model,
            'isEnabled' => $isEnabled,
        ]);
    }


    public function actionSolicitarEspacio()
    {
        $isEnabled = false;


        $model = new Prestamo();
        // Asignar valores al modelo de Prestamo
        $model->tipoprestamo_id = 'ESP';


        if (!Yii::$app->user->isGuest) {
            // Accede a los datos del usuario actualmente autenticado
            $userData = Yii::$app->user->identity;
            if ($userData->tipo_usuario === User::TYPE_EXTERNO || $userData->tipo_usuario === User::TYPE_ESTUDIANTE || $userData->tipo_usuario === USER::TYPE_DOCENTE) {
                $model->cedula_solicitante = $userData->username;
                $isEnabled = true;
            }
            $model->biblioteca_idbiblioteca = Yii::$app->session->get('selectBiblioteca');
        }



        if ($this->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {


                $personalU = InformacionpersonalD::find()->where(['CIInfPer' => $model->cedula_solicitante])->one();
                $estudiante = Informacionpersonal::find()->where(['CIInfPer' => $model->cedula_solicitante])->one();
                $externo = Personaldata::find()->where(['Ci' => $model->cedula_solicitante])->one();

                // Verifica qué relación no es nula y asigna la cédula correspondiente
                if ($personalU !== null) {
                    $model->informacionpersonal_d_CIInfPer = $personalU->CIInfPer;
                } elseif ($estudiante !== null) {
                    $model->informacionpersonal_CIInfPer = $estudiante->CIInfPer;
                } elseif ($externo !== null) {
                    $model->personaldata_Ci = $externo->Ci;
                }

                if ($personalU == null && $estudiante == null && $externo == null) {
                    Yii::$app->session->setFlash('error', 'No existe el solicitante en el sistema.');
                    return $this->redirect(Url::to(['site/error']));
                }
                // Asignar valores y calcular la fecha de entrega
                list($horas, $minutos) = explode(':', $model->intervalo_solicitado);

                $fechaSolicitud = new \DateTime($model->fecha_solicitud);
                $model->fecha_solicitud = Yii::$app->formatter->asDatetime($fechaSolicitud, 'yyyy-MM-dd HH:mm:ss');
                $intervalo = new \DateInterval('PT' . $horas . 'H' . $minutos . 'M'); // PT horas minutos
                $fechaEntrega = $fechaSolicitud->add($intervalo);
                $model->fechaentrega = Yii::$app->formatter->asDatetime($fechaEntrega, 'yyyy-MM-dd HH:mm:ss');


                // Verificar si el modelo se guarda con éxito
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Hemos recibido tu solicitud');
                    return $this->redirect(['prestamo/view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                } else {
                    Yii::$app->session->setFlash('error', 'No se pudo realizar la solicitud.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('solicitar-esp', [
            'model' => $model,
            'isEnabled' => $isEnabled,
        ]);
    }
}
