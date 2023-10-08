<?php

namespace app\controllers;

use Yii;
use app\models\Prestamo;
use app\models\PrestamoSearch;
use app\models\Libro;
use app\models\Pc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prestamo model.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @param string $personaldata_Ci Personaldata Ci
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $biblioteca_idbiblioteca, $personaldata_Ci)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $biblioteca_idbiblioteca, $personaldata_Ci),
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
        //$Cedula = \Yii::$app->user->identity->personaldata;
        //$model->personaldata_Ci = $Cedula;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci]);
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
     * @param string $personaldata_Ci Personaldata Ci
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $biblioteca_idbiblioteca, $personaldata_Ci)
    {
        $model = $this->findModel($id, $biblioteca_idbiblioteca, $personaldata_Ci);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci]);
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
     * @param string $personaldata_Ci Personaldata Ci
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $biblioteca_idbiblioteca, $personaldata_Ci)
    {
        $this->findModel($id, $biblioteca_idbiblioteca, $personaldata_Ci)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prestamo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @param string $personaldata_Ci Personaldata Ci
     * @return Prestamo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $biblioteca_idbiblioteca, $personaldata_Ci)
    {
        if (($model = Prestamo::findOne(['id' => $id, 'biblioteca_idbiblioteca' => $biblioteca_idbiblioteca, 'personaldata_Ci' => $personaldata_Ci])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionPrestarlibro($id)
    {    
        if (\Yii::$app->user->isGuest) {
            // El usuario no está autenticado, redirigirlo a la página de inicio de sesión
            return $this->redirect(['site/login']); // Reemplaza 'site/login' con la ruta a tu página de inicio de sesión
        }
        
        // Cargar el modelo de libro basado en el $id recibido        
        $libro = Libro::findOne(['codigo_barras' => $id]);

        // Verificar si el libro existe
        if (!$libro) {
            throw new NotFoundHttpException('El libro no se encontró.');
        }

        Yii::$app->session->set('prestarlib', true);
        $model = new Prestamo();

        // Obtener el usuario actual
        $usuario = \Yii::$app->user->identity;

        // Asignar valores al modelo de Prestamo
        $model->personaldata_Ci = $usuario->personaldata;
        $model->tipoprestamo_id = 'LIB';
        $model->biblioteca_idbiblioteca = $libro->biblioteca_idbiblioteca; // Campus donde se encuentra el usuario... mejorar (Y)
        $model->libro_codigo_barras = $id;
        $model->libro_biblioteca_idbiblioteca = $libro->biblioteca_idbiblioteca; //Campus donde se encuentra el libro

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionPrestarpc($id)
    {    
        if (\Yii::$app->user->isGuest) {
            // El usuario no está autenticado, redirigirlo a la página de inicio de sesión
            return $this->redirect(['site/login']); // Reemplaza 'site/login' con la ruta a tu página de inicio de sesión
        }
        
        // Cargar el modelo del computador basado en el $id recibido
        
        $pc = Pc::findOne(['idpc' => $id]);

    // Verificar si el computador existe
        if (!$pc) {
            throw new NotFoundHttpException('El computador no se encontró.');
        }

        Yii::$app->session->set('prestarcomp', true);

        $model = new Prestamo();

    // Obtener el usuario actual
        $usuario = \Yii::$app->user->identity;

    // Asignar valores al modelo de Prestamo
        $model->personaldata_Ci = $usuario->personaldata;
        $model->tipoprestamo_id = 'COMP';
        $model->biblioteca_idbiblioteca = $pc->biblioteca_idbiblioteca; // Campus donde se encuentra el usuario... mejorar (Y)
        $model->pc_idpc = $id;
        $model->pc_biblioteca_idbiblioteca = $pc->biblioteca_idbiblioteca; //Campus donde se encuentra el computador

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
}


    public function actionPrestarespacio()
    {    
            // Verificar si el usuario está autenticado
    if (\Yii::$app->user->isGuest) {
        // El usuario no está autenticado, redirigirlo a la página de inicio de sesión
        return $this->redirect(['site/login']); // Reemplaza 'site/login' con la ruta a tu página de inicio de sesión
    }

        $model = new Prestamo();
        Yii::$app->session->set('prestaresp', true);

        // Obtener el usuario actual
        $usuario = \Yii::$app->user->identity;

        // Asignar valores al modelo de Prestamo
        $model->personaldata_Ci = $usuario->personaldata;
        $model->tipoprestamo_id = 'ESP';
       
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca, 'personaldata_Ci' => $model->personaldata_Ci]);
        }

        return $this->render('create', [
            'model' => $model,
      ]);
    }
}
