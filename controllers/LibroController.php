<?php

namespace app\controllers;

use app\models\Libro;
use app\models\LibroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LibroController implements the CRUD actions for Libro model.
 */
class LibroController extends Controller
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
     * Lists all Libro models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LibroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libro model.
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
     * Creates a new Libro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Libro();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Libro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $biblioteca_idbiblioteca)
    {
        $model = $this->findModel($id, $biblioteca_idbiblioteca);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'biblioteca_idbiblioteca' => $model->biblioteca_idbiblioteca]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Libro model.
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
     * Finds the Libro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @param int $biblioteca_idbiblioteca Biblioteca Idbiblioteca
     * @return Libro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $biblioteca_idbiblioteca)
    {
        if (($model = Libro::findOne(['id' => $id, 'biblioteca_idbiblioteca' => $biblioteca_idbiblioteca])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
