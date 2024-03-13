<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Status', 'tipo_usuario'], 'integer'],
            [['username', 'password', 'Auth_key', 'Created_at', 'Updated_at'], 'safe'],
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
        $query = User::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'Status' => $this->Status,
            'tipo_usuario' => $this->tipo_usuario,
           // 'Created_at' => $this->Created_at,
           // 'Updated_at' => $this->Updated_at,
           
        ]);

        if (!empty($this->Created_at)) {
            // Cambiamos el formato de la fecha para hacerlo compatible con la base de datos
            $fechaSolicitud = \Yii::$app->formatter->asDatetime($this->Created_at, 'php:Y-m-d H:i:s');

            // Separar la fecha en formato Y-m-d H:i:s en fecha y hora
            list($fecha, $hora) = explode(' ', $fechaSolicitud);

            // Convertir la fecha en formato Y-m-d a un rango de tiempo en ese día
            $fechaInicio = $fecha . ' 00:00:00';
            $fechaFin = $fecha . ' 23:59:59';

            // Aplicar el filtro
            $query->andFilterWhere([
                'between', 'Created_at', $fechaInicio, $fechaFin
            ]);
        }

        if (!empty($this->Updated_at)) {
            // Cambiamos el formato de la fecha para hacerlo compatible con la base de datos
            $fechaSolicitud = \Yii::$app->formatter->asDatetime($this->Updated_at, 'php:Y-m-d H:i:s');

            // Separar la fecha en formato Y-m-d H:i:s en fecha y hora
            list($fecha, $hora) = explode(' ', $fechaSolicitud);

            // Convertir la fecha en formato Y-m-d a un rango de tiempo en ese día
            $fechaInicio = $fecha . ' 00:00:00';
            $fechaFin = $fecha . ' 23:59:59';

            // Aplicar el filtro
            $query->andFilterWhere([
                'between', 'Updated_at', $fechaInicio, $fechaFin
            ]);
        }


        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'Auth_key', $this->Auth_key]);

        return $dataProvider;
    }
}
