<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ejemplar;
use Yii;

/**
 * EjemplarSearch represents the model behind the search form of `app\models\Ejemplar`.
 */
class EjemplarSearch extends Ejemplar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Status', 'libro_id', 'biblioteca_idbiblioteca'], 'integer'],
            [['codigo_barras', 'ubicacion'], 'safe'],
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
        $query = Ejemplar::find();

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
            'libro_id' => $this->libro_id,
            'biblioteca_idbiblioteca' => $this->biblioteca_idbiblioteca,
        ]);

        $query->andFilterWhere(['like', 'codigo_barras', $this->codigo_barras])
            ->andFilterWhere(['like', 'ubicacion', $this->ubicacion]);

        // Aplicar filtros adicionales basados en el tipo de usuario
        $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

        if ($tipoUsuario === User::TYPE_EXTERNO || $tipoUsuario === User::TYPE_ESTUDIANTE || $tipoUsuario === User::TYPE_DOCENTE) {
            $query->andWhere(['Status' => 1]);
        }

        return $dataProvider;
    }
}
