<?php

namespace app\controllers;

use Yii;
use app\models\Libro;
use app\models\Pc;
use app\models\Biblioteca;
use app\models\Prestamo;
use app\models\PrestamoSearch;
use app\models\Tipoprestamo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\JsExpression;



/**
 * PrestamoController implements the CRUD actions for Prestamo model.
 */
class PrestamoController extends Controller
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

    /**
     * Lists all Prestamo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PrestamoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->orderBy(['fecha_solicitud' => SORT_DESC]); // Ordenar por fecha de solicitud, los más recientes primero

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prestamo model.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $biblioteca_idbiblioteca)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $biblioteca_idbiblioteca),
        ]);
    }

    /**
     * Creates a new Prestamo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Prestamo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                list($horas, $minutos) = explode(':', $model->intervalo_solicitado);



                $fechaSolicitud = new \DateTime($model->fecha_solicitud);
                $model->fecha_solicitud = Yii::$app->formatter->asDatetime($fechaSolicitud, 'yyyy-MM-dd HH:mm:ss');
                $intervalo = new \DateInterval('PT' . $horas . 'H' . $minutos . 'M'); // PT horas minutos
                $fechaEntrega = $fechaSolicitud->add($intervalo);
                $model->fechaentrega = Yii::$app->formatter->asDatetime($fechaEntrega, 'yyyy-MM-dd HH:mm:ss');

                if ($model->tipoprestamo_id === 'COMP') {
                    $model->pc_biblioteca_idbiblioteca = $model->biblioteca_idbiblioteca;
                } elseif ($model->tipoprestamo_id === 'LIB') {
                    $model->libro_biblioteca_idbiblioteca = $model->biblioteca_idbiblioteca;
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Prestamo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $biblioteca_idbiblioteca)
    {
        $model = $this->findModel($id, $biblioteca_idbiblioteca);

        // Verificar si se envió un formulario
        if ($model->load(\Yii::$app->request->post())) {
            // Asignar valores y calcular la fecha de entrega
            list($horas, $minutos) = explode(':', $model->intervalo_solicitado);

            $fechaSolicitud = new \DateTime($model->fecha_solicitud);
            $intervalo = new \DateInterval('PT' . $horas . 'H' . $minutos . 'M'); // PT horas minutos
            $fechaEntrega = $fechaSolicitud->add($intervalo);
            $model->fechaentrega = Yii::$app->formatter->asDatetime($fechaEntrega, 'yyyy-MM-dd HH:mm:ss');

            // Verificar si el modelo se guarda con éxito
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Prestamo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $biblioteca_idbiblioteca)
    {
        $this->findModel($id, $biblioteca_idbiblioteca)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prestamo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return Prestamo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $biblioteca_idbiblioteca)
    {
        if (($model = Prestamo::findOne(['id' => $id, 'biblioteca_idbiblioteca' => $biblioteca_idbiblioteca])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
