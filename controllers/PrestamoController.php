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

    public function actionPrestarlibro($id)
    {

        // Cargar el modelo de libro basado en el $id recibido        
        $libro = Libro::findOne(['id' => $id]);

        // Verificar si el libro existe
        if (!$libro) {
            throw new NotFoundHttpException('El libro no se encontró.');
        }

        $model = new Prestamo();

        if (!Yii::$app->user->isGuest) {
            $userData = Yii::$app->user->identity;

            // Verifica qué relación no es nula y asigna la cédula correspondiente
            if ($userData->personaldata !== null) {
                $model->cedula_solicitante = $userData->personaldata->Ci;
                $model->personaldata_Ci = $model->cedula_solicitante;
            } elseif ($userData->informacionpersonal !== null) {
                $model->cedula_solicitante = $userData->informacionpersonal->CIInfPer;
                $model->informacionpersonal_CIInfPer = $model->cedula_solicitante;
            } elseif ($userData->informacionpersonalD !== null) {
                $model->cedula_solicitante = $userData->informacionpersonalD->CIInfPer;
                $model->informacionpersonal_d_CIInfPer = $model->cedula_solicitante;;
            }
        }

        $model->tipoprestamo_id = 'LIB';

        $model->biblioteca_idbiblioteca = $libro->biblioteca_idbiblioteca; // Campus donde se encuentra el usuario... mejorar (Y)
        $model->libro_id = $id;
        $model->libro_biblioteca_idbiblioteca = $libro->biblioteca_idbiblioteca; //Campus donde se encuentra el libro

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

        return $this->renderAjax('prestarlib', [
            'model' => $model,
        ]);
    }


    public function actionPrestarpc($id)
    {
        $pc = Pc::findOne(['idpc' => $id]);

        // Verificar si el computador existe
        if (!$pc) {
            throw new NotFoundHttpException('El computador no se encontró.');
        }

        $model = new Prestamo();

        if (!Yii::$app->user->isGuest) {
            $userData = Yii::$app->user->identity;

            // Verifica qué relación no es nula y asigna la cédula correspondiente
            if ($userData->personaldata !== null) {
                $model->cedula_solicitante = $userData->personaldata->Ci;
                $model->personaldata_Ci = $model->cedula_solicitante;
            } elseif ($userData->informacionpersonal !== null) {
                $model->cedula_solicitante = $userData->informacionpersonal->CIInfPer;
                $model->informacionpersonal_CIInfPer = $model->cedula_solicitante;
            } elseif ($userData->informacionpersonalD !== null) {
                $model->cedula_solicitante = $userData->informacionpersonalD->CIInfPer;
                $model->informacionpersonal_d_CIInfPer = $model->cedula_solicitante;;
            }
        }

        $model->intervalo_solicitado = '01:00:00';
        $model->tipoprestamo_id = 'COMP';
        $model->biblioteca_idbiblioteca = $pc->biblioteca_idbiblioteca; // Campus donde se encuentra el usuario... mejorar (Y)
        $model->pc_idpc = $id;
        $model->pc_biblioteca_idbiblioteca = $pc->biblioteca_idbiblioteca; //Campus donde se encuentra el computador

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

        return $this->renderAjax('prestarcomp', [
            'model' => $model,
        ]);
    }


    public function actionPrestarespacio()
    {

        $model = new Prestamo();

        if (!Yii::$app->user->isGuest) {
            $userData = Yii::$app->user->identity;

            // Verifica qué relación no es nula y asigna la cédula correspondiente
            if ($userData->personaldata !== null) {
                $model->cedula_solicitante = $userData->personaldata->Ci;
                $model->personaldata_Ci = $model->cedula_solicitante;
            } elseif ($userData->informacionpersonal !== null) {
                $model->cedula_solicitante = $userData->informacionpersonal->CIInfPer;
                $model->informacionpersonal_CIInfPer = $model->cedula_solicitante;
            } elseif ($userData->informacionpersonalD !== null) {
                $model->cedula_solicitante = $userData->informacionpersonalD->CIInfPer;
                $model->informacionpersonal_d_CIInfPer = $model->cedula_solicitante;;
            }
        }
        // Asignar valores al modelo de Prestamo
        $model->tipoprestamo_id = 'ESP';

        //$biblioteca = \Yii::$app->controller->findBibliotecaById(['idbiblioteca' => $model->biblioteca_idbiblioteca]);
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

        return $this->renderAjax('prestaresp', [
            'model' => $model,
        ]);
    }


    public function actionInfo()
    {
        $mesSeleccionado = Yii::$app->request->get('mes', date('m'));
        $anioSeleccionado = Yii::$app->request->get('anio', date('Y'));
        $bibliotecaSeleccionada = Yii::$app->request->get('biblioteca_idbiblioteca', null);

        // Obtén las bibliotecas disponibles
        $bibliotecas = Biblioteca::find()->all();

        // Obtener los datos de libro limitando a 10 elementos
        $queryLibro = new \yii\db\Query();
        $queryLibro->select(['MONTH(fecha_solicitud) AS mes', 'libro_id', 'COUNT(*) AS cantidad'])
            ->from('prestamo')
            ->where(['MONTH(fecha_solicitud)' => $mesSeleccionado, 'YEAR(fecha_solicitud)' => $anioSeleccionado])
            ->andFilterWhere(['biblioteca_idbiblioteca' => $bibliotecaSeleccionada]) // Cambio aquí
            ->groupBy(['mes', 'libro_id'])
            ->orderBy(['mes' => SORT_ASC, 'cantidad' => SORT_DESC])
            ->distinct()
            ->limit(10); // Limitar a 10 elementos

        $dataLibro = $queryLibro->all();

        $books = [];

        foreach ($dataLibro as $row) {
            $mes = $row['mes'];
            $libroId = $row['libro_id'];
            $cantidad = $row['cantidad'];

            // Obtén información del libro, incluyendo el nombre
            $libro = Libro::findOne($libroId);

            if ($libro && $libro->titulo !== null && $libro->titulo !== 'No disponible') {
                $nombreLibro = $libro->titulo;
                $books[] = [
                    'mes' => $mes,
                    'libro' => $nombreLibro,
                    'cantidad' => $cantidad,
                ];
            }
        }

        // Obtener los datos de computadora limitando a 10 elementos
        $queryPc = new \yii\db\Query();
        $queryPc->select(['MONTH(fecha_solicitud) AS mes', 'pc_idpc', 'COUNT(*) AS cantidad'])
            ->from('prestamo')
            ->where(['MONTH(fecha_solicitud)' => $mesSeleccionado, 'YEAR(fecha_solicitud)' => $anioSeleccionado])
            ->andFilterWhere(['biblioteca_idbiblioteca' => $bibliotecaSeleccionada]) // Cambio aquí
            ->groupBy(['mes', 'pc_idpc'])
            ->orderBy(['mes' => SORT_ASC, 'cantidad' => SORT_DESC])
            ->distinct()
            ->limit(10); // Limitar a 10 elementos

        $dataPc = $queryPc->all();

        $computadoras = [];

        foreach ($dataPc as $row) {
            $mes = $row['mes'];
            $pcId = $row['pc_idpc'];
            $cantidad = $row['cantidad'];

            // Obtén información de la computadora, incluyendo el nombre
            $computadora = Pc::findOne($pcId);

            if ($computadora && $computadora->idpc !== null && $computadora->idpc !== 'No disponible') {
                $nombreComputadora = $computadora->nombre;
                $computadoras[] = [
                    'mes' => $mes,
                    'computadora' => $nombreComputadora,
                    'cantidad' => $cantidad,
                ];
            }
        }

        // Obtener los datos de tipo de préstamo
        $queryTipoPrestamo = new \yii\db\Query();
        $queryTipoPrestamo->select(['tipoprestamo_id', 'COUNT(*) AS cantidad'])
            ->from('prestamo')
            ->where(['MONTH(fecha_solicitud)' => $mesSeleccionado, 'YEAR(fecha_solicitud)' => $anioSeleccionado])
            ->andFilterWhere(['biblioteca_idbiblioteca' => $bibliotecaSeleccionada]) // Cambio aquí
            ->groupBy('tipoprestamo_id');

        $dataTipoPrestamo = $queryTipoPrestamo->all();

        $tiposPrestamo = [];

        foreach ($dataTipoPrestamo as $row) {
            $tipoPrestamoId = $row['tipoprestamo_id'];
            $cantidad = $row['cantidad'];

            // Obtén información del tipo de préstamo
            $tipoPrestamo = Tipoprestamo::findOne($tipoPrestamoId);

            $tiposPrestamo[] = [
                'nombre' => $tipoPrestamo->nombre_tipo,
                'cantidad' => $cantidad,
            ];
        }

        return $this->render('info', [
            'mesSeleccionado' => $mesSeleccionado,
            'anioSeleccionado' => $anioSeleccionado,
            'bibliotecas' => $bibliotecas,
            'bibliotecaSeleccionada' => $bibliotecaSeleccionada,
            'books' => $books,
            'computadoras' => $computadoras,
            'tiposPrestamo' => $tiposPrestamo,
        ]);
    }


    public function actionEstadisticalibro()
    {

        $mesSeleccionado = Yii::$app->request->get('mes', date('m'));
        $anioSeleccionado = Yii::$app->request->get('anio', date('Y'));
        $bibliotecaSeleccionada = Yii::$app->request->get('bibliotecaId', null);
        $asignaturaSeleccionada =  Yii::$app->request->get('asignaturaId', null);

        $query = new \yii\db\Query();
        
        $query->select(['libro.titulo', 'COUNT(*) as total'])
            ->from('prestamo')
            ->where(['MONTH(fecha_solicitud)' => $mesSeleccionado, 'YEAR(fecha_solicitud)' => $anioSeleccionado])
            ->join('INNER JOIN', 'libro', 'libro.id = prestamo.libro_id AND libro.biblioteca_idbiblioteca = prestamo.libro_biblioteca_idbiblioteca')
            ->groupBy('libro.titulo')
            ->orderBy('total DESC')
            ->limit(10);

        if ($asignaturaSeleccionada !== null) {
            $query->andWhere(['libro.asignatura_id' => $asignaturaSeleccionada]);
        }

        if ($bibliotecaSeleccionada !== null) {
            $query->andWhere(['prestamo.biblioteca_idbiblioteca' => $bibliotecaSeleccionada]); // Cambio aquí
        }

        $librosMasSolicitados = $query->all();

        $labels = [];
        $data = [];
        foreach ($librosMasSolicitados as $libro) {
            $labels[] = $libro['titulo'];
            $data[] = $libro['total'];
        }

        // Datos para el gráfico
        $chartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        return $this->render('estadisticalibro', [
            'librosMasSolicitados' =>$librosMasSolicitados,
            'chartData' => $chartData, // Pasar los datos del gráfico a la vista
            'mesSeleccionado' => $mesSeleccionado,
            'anioSeleccionado' => $anioSeleccionado,
            'bibliotecaSeleccionada' => $bibliotecaSeleccionada,
            'asignaturaSeleccionada' => $asignaturaSeleccionada,
        ]);
    }
}
