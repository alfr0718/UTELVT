<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Libro;

/**
 * LibroSearch represents the model behind the search form of `app\models\Libro`.
 */
class LibroSearch extends Libro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'n_ejemplares', 'biblioteca_idbiblioteca'], 'integer'],
            [['codigo_barras', 'titulo', 'autor', 'isbn', 'cute', 'editorial', 'anio_publicacion', 'estado', 'link', 'categoria_id', 'asignatura_id', 'pais_codigopais'], 'safe'],
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
        $query = Libro::find();

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
            'anio_publicacion' => $this->anio_publicacion,
            'n_ejemplares' => $this->n_ejemplares,
            'biblioteca_idbiblioteca' => $this->biblioteca_idbiblioteca,
        ]);

        $query->andFilterWhere(['like', 'codigo_barras', $this->codigo_barras])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'autor', $this->autor])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'cute', $this->cute])
            ->andFilterWhere(['like', 'editorial', $this->editorial])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'categoria_id', $this->categoria_id])
            ->andFilterWhere(['like', 'asignatura_id', $this->asignatura_id])
            ->andFilterWhere(['like', 'pais_codigopais', $this->pais_codigopais]);

        return $dataProvider;
    }
}
