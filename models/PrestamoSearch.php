<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prestamo;
use Yii;

/**
 * PrestamoSearch represents the model behind the search form of `app\models\Prestamo`.
 */
class PrestamoSearch extends Prestamo
{

    public $cedula_solicitante;
    public $nombre_pc;
    public $codigo_barras;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_pc', 'codigo_barras'], 'string'],
            [['id', 'biblioteca_idbiblioteca', 'object_id', 'Status'], 'integer'],
            [['cedula_solicitante', 'fecha_solicitud', 'fechaentrega', 'tipoprestamo_id', 'personaldata_Ci', 'informacionpersonal_d_CIInfPer', 'informacionpersonal_CIInfPer'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Prestamo::find();
        $query->joinWith('pcIdpc')
            ->joinWith('ejemplar')
            ->andFilterWhere([
                'or',
                ['and', ['prestamo.tipoprestamo_id' => 'LIB'], ['ejemplar.id' => $this->object_id]],
                ['and', ['prestamo.tipoprestamo_id' => 'COMP'], ['pc.id' => $this->object_id]],
                ['and', ['prestamo.tipoprestamo_id' => 'ESP']],

            ]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if (!empty($this->fecha_solicitud)) {
            // Cambiamos el formato de la fecha para hacerlo compatible con la base de datos
            $fechaSolicitud = \Yii::$app->formatter->asDatetime($this->fecha_solicitud, 'php:Y-m-d H:i:s');

            // Separar la fecha en formato Y-m-d H:i:s en fecha y hora
            list($fecha, $hora) = explode(' ', $fechaSolicitud);

            // Convertir la fecha en formato Y-m-d a un rango de tiempo en ese día
            $fechaInicio = $fecha . ' 00:00:00';
            $fechaFin = $fecha . ' 23:59:59';

            // Aplicar el filtro
            $query->andFilterWhere([
                'between', 'fecha_solicitud', $fechaInicio, $fechaFin
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'fecha_solicitud' => $this->fecha_solicitud,
            'fechaentrega' => $this->fechaentrega,
            'prestamo.biblioteca_idbiblioteca' => $this->biblioteca_idbiblioteca,
            'Status' => $this->Status,
            //'pc_biblioteca_idbiblioteca' => $this->pc_biblioteca_idbiblioteca,
            //'libro_id' => $this->libro_id,
            //'libro_biblioteca_idbiblioteca' => $this->libro_biblioteca_idbiblioteca,
            'prestamo.object_id' => $this->object_id,

        ]);

        $query->andFilterWhere(['like', 'tipoprestamo_id', $this->tipoprestamo_id])
            //PARA CEDULA_SOLICITANTE
            ->andFilterWhere(['like', 'personaldata_Ci', $this->cedula_solicitante])
            ->orFilterWhere(['like', 'informacionpersonal_d_CIInfPer', $this->cedula_solicitante])
            ->orFilterWhere(['like', 'informacionpersonal_CIInfPer', $this->cedula_solicitante])
            //PARA OBJETO
            ->andFilterWhere([
                'or',
                ['like', 'pc.nombre', $this->nombre_pc],
                ['like', 'ejemplar.codigo_barras', $this->codigo_barras],
            ]);


        if ($this->fecha_solicitud === null) {
            $now = new \DateTime();

            // Establecer solo la fecha sin la hora
            $this->fecha_solicitud = $now->format('Y-m-d');

            // Realizar una búsqueda con los parámetros actuales
            $dataProvider = $this->search(Yii::$app->request->queryParams);
        }

        // Ordenar los datos por fecha de solicitud en orden descendente, los más recientes primero
        $dataProvider->query->orderBy(['fecha_solicitud' => SORT_DESC]);

        if ($this->biblioteca_idbiblioteca === null) {
            if (Yii::$app->session->has('selectBiblioteca')) {
                $this->biblioteca_idbiblioteca = Yii::$app->session->get('selectBiblioteca');
                $dataProvider = $this->search(Yii::$app->request->queryParams);
            }
        }

        return $dataProvider;
    }
}
