<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prestamo;

/**
 * PrestamoSearch represents the model behind the search form of `app\models\Prestamo`.
 */
class PrestamoSearch extends Prestamo
{

    public $cedula_solicitante;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pc_idpc'], 'string'],
            [['id', 'biblioteca_idbiblioteca', 'pc_biblioteca_idbiblioteca', 'libro_id', 'libro_biblioteca_idbiblioteca'], 'integer'],
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
        $query->joinWith('pcIdpc'); // Realizar un join con la tabla datospersonalesed
        // add conditions that should always apply here

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
            'biblioteca_idbiblioteca' => $this->biblioteca_idbiblioteca,

            'pc_biblioteca_idbiblioteca' => $this->pc_biblioteca_idbiblioteca,
            'libro_id' => $this->libro_id,
            'libro_biblioteca_idbiblioteca' => $this->libro_biblioteca_idbiblioteca,
        ]);

        $query->andFilterWhere(['like', 'tipoprestamo_id', $this->tipoprestamo_id])
        ->andFilterWhere(['like', 'pc.nombre', $this->pc_idpc])
            /*->andFilterWhere(['like', 'personaldata_Ci', $this->personaldata_Ci])
            ->andFilterWhere(['like', 'informacionpersonal_d_CIInfPer', $this->informacionpersonal_d_CIInfPer])
            ->andFilterWhere(['like', 'informacionpersonal_CIInfPer', $this->informacionpersonal_CIInfPer]);*/


            ->andFilterWhere(['like', 'personaldata_Ci', $this->cedula_solicitante])
            ->orFilterWhere(['like', 'informacionpersonal_d_CIInfPer', $this->cedula_solicitante])
            ->orFilterWhere(['like', 'informacionpersonal_CIInfPer', $this->cedula_solicitante]);

        return $dataProvider;
    }
}
