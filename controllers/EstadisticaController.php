<?php

namespace app\controllers;

use app\models\Biblioteca;
use app\models\Libro;
use app\models\Pc;
use app\models\Prestamo;
use app\models\Tipoprestamo;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SolicitudController implements the las acciones de prestamos de servicios.
 */
class EstadisticaController extends Controller
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


    //EstadísticaGeneral
    public function actionEstadisticaGeneral()
    {
        $mesSeleccionado = Yii::$app->request->get('mes', date('m'));
        $anioSeleccionado = Yii::$app->request->get('anio', date('Y'));
        $bibliotecaSeleccionada = Yii::$app->request->get('biblioteca_idbiblioteca', null);

        // Obtén las bibliotecas disponibles
        $bibliotecas = Biblioteca::find()->all();

        // Obtener los datos de libro limitando a 10 elementos
        $queryLibro = new \yii\db\Query();
        $queryLibro->select(['MONTH(p.fecha_solicitud) AS mes', 'e.libro_id as libro', 'COUNT(*) AS cantidad'])
            ->from(['p' => 'prestamo'])
            ->leftJoin('ejemplar e', 'p.object_id = e.id') // Unir con la tabla ejemplar
            ->where([
                'MONTH(p.fecha_solicitud)' => $mesSeleccionado,
                'YEAR(p.fecha_solicitud)' => $anioSeleccionado,
                'p.tipoprestamo_id' => 'LIB' // Filtrar por tipo_prestamoid igual a 'LIB'
            ])
            ->andFilterWhere(['p.biblioteca_idbiblioteca' => $bibliotecaSeleccionada])
            ->groupBy(['mes', 'libro'])
            ->orderBy(['mes' => SORT_ASC, 'cantidad' => SORT_DESC])
            ->distinct()
            ->limit(10); // Limitar a 10 elementos

        $dataLibro = $queryLibro->all();

        $books = [];

        foreach ($dataLibro as $row) {
            $mes = $row['mes'];
            $libroId = $row['libro'];
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
        $queryPc->select(['MONTH(fecha_solicitud) AS mes', 'object_id', 'COUNT(*) AS cantidad'])
            ->from('prestamo')
            ->where([
                'MONTH(fecha_solicitud)' => $mesSeleccionado,
                'YEAR(fecha_solicitud)' => $anioSeleccionado,
                'tipoprestamo_id' => 'COMP' // Filtrar por tipo_prestamoid igual a 'LIB'
            ])
            ->andFilterWhere(['biblioteca_idbiblioteca' => $bibliotecaSeleccionada]) // Cambio aquí
            ->groupBy(['mes', 'object_id'])
            ->orderBy(['mes' => SORT_ASC, 'cantidad' => SORT_DESC])
            ->distinct()
            ->limit(10); // Limitar a 10 elementos

        $dataPc = $queryPc->all();

        $computadoras = [];

        foreach ($dataPc as $row) {
            $mes = $row['mes'];
            $pcId = $row['object_id'];
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

        return $this->render('general', [
            'mesSeleccionado' => $mesSeleccionado,
            'anioSeleccionado' => $anioSeleccionado,
            'bibliotecas' => $bibliotecas,
            'bibliotecaSeleccionada' => $bibliotecaSeleccionada,
            'books' => $books,
            'computadoras' => $computadoras,
            'tiposPrestamo' => $tiposPrestamo,
        ]);
    }


    public function actionIndexLibro(){

        return $this->render('index-libro');
    }

    // ESTADISTICA DE LIBROS POR ASIGNATURA MES-AÑO
    public function actionAsignaturaLibro()
    {

        $mesSeleccionado = Yii::$app->request->get('mes', date('m'));
        $anioSeleccionado = Yii::$app->request->get('anio', date('Y'));


        $bibliotecaSeleccionada = Yii::$app->request->get('bibliotecaId', null);
        $asignaturaSeleccionada = Yii::$app->request->get('asignaturaId', null);

        $query = new \yii\db\Query();

        $query->select(['libro.titulo as titulo', 'COUNT(*) as total'])
            ->from(['p' => 'prestamo'])
            ->leftJoin('ejemplar e', 'p.object_id = e.id') // Unir con la tabla ejemplar
            ->where([
                'MONTH(p.fecha_solicitud)' => $mesSeleccionado,
                'YEAR(p.fecha_solicitud)' => $anioSeleccionado,
                'p.tipoprestamo_id' => 'LIB' // Filtrar por tipo_prestamoid igual a 'LIB'
            ])
            ->join('INNER JOIN', 'libro', 'libro.id = e.libro_id')
            ->groupBy('libro.id')
            ->orderBy('total DESC')
            ->limit(10);



        if ($bibliotecaSeleccionada !== null && $asignaturaSeleccionada !== null) {
            $query->andFilterWhere([
                'libro.asignatura_IdAsig' => $asignaturaSeleccionada,
                'p.biblioteca_idbiblioteca' => $bibliotecaSeleccionada
            ]);
        } elseif ($asignaturaSeleccionada !== null) {
            $query->andWhere(['libro.asignatura_IdAsig' => $asignaturaSeleccionada]);
        } elseif ($bibliotecaSeleccionada !== null) {
            $query->andWhere(['p.biblioteca_idbiblioteca' => $bibliotecaSeleccionada]);
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

        return $this->render('libro/asignaturaMesAño', [
            'librosMasSolicitados' => $librosMasSolicitados,
            'chartData' => $chartData, // Pasar los datos del gráfico a la vista
            'mesSeleccionado' => $mesSeleccionado,
            'anioSeleccionado' => $anioSeleccionado,
            'bibliotecaSeleccionada' => $bibliotecaSeleccionada,
            'asignaturaSeleccionada' => $asignaturaSeleccionada,
        ]);
    }

    // ESTADISTICA DE LIBROS POR ASIGNATURA FECHA INICIO - FECHA FIN

    public function actionAsignaturaLibroInicioFin()
    {

        $fechaInicio = Yii::$app->request->get('fechaInicio', date('Y-m-01'));
        $fechaFin = Yii::$app->request->get('fechaFin', date('Y-m-t'));

        $bibliotecaSeleccionada = Yii::$app->request->get('bibliotecaId', null);
        $asignaturaSeleccionada = Yii::$app->request->get('asignaturaId', null);

        $query = new \yii\db\Query();

        $query->select(['libro.titulo as titulo', 'COUNT(*) as total'])
            ->from(['p' => 'prestamo'])
            ->leftJoin('ejemplar e', 'p.object_id = e.id') // Unir con la tabla ejemplar
            ->where([
                'AND',
                [
                    'BETWEEN',
                    'p.fecha_solicitud',
                    $fechaInicio,
                    $fechaFin
                ],
                ['p.tipoprestamo_id' => 'LIB']
            ])
            ->join('INNER JOIN', 'libro', 'libro.id = e.libro_id')
            ->groupBy('libro.id')
            ->orderBy('total DESC')
            ->limit(10);



        if ($bibliotecaSeleccionada !== null && $asignaturaSeleccionada !== null) {
            $query->andFilterWhere([
                'libro.asignatura_IdAsig' => $asignaturaSeleccionada,
                'p.biblioteca_idbiblioteca' => $bibliotecaSeleccionada
            ]);
        } elseif ($asignaturaSeleccionada !== null) {
            $query->andWhere(['libro.asignatura_IdAsig' => $asignaturaSeleccionada]);
        } elseif ($bibliotecaSeleccionada !== null) {
            $query->andWhere(['p.biblioteca_idbiblioteca' => $bibliotecaSeleccionada]);
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

        return $this->render('libro/asignaturaInicioFin', [
            'librosMasSolicitados' => $librosMasSolicitados,
            'chartData' => $chartData, // Pasar los datos del gráfico a la vista
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'bibliotecaSeleccionada' => $bibliotecaSeleccionada,
            'asignaturaSeleccionada' => $asignaturaSeleccionada,
        ]);
    }
}
