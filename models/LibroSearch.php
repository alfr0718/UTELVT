<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Libro;
use Yii;

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
            [['id', 'asignatura_IdAsig', 'biblioteca_idbiblioteca' ], 'integer'],
            [['titulo', 'autor', 'isbn', 'cute', 'editorial', 'anio_publicacion', 'categoria_id','seccion_id', 'pais_cod_pais'], 'safe'],
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
            'seccion_id' => $this->seccion_id,
            'categoria_id' => $this->categoria_id,
            'asignatura_IdAsig' => $this->asignatura_IdAsig,
            'biblioteca_idbiblioteca' => $this->biblioteca_idbiblioteca,

        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'autor', $this->autor])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'cute', $this->cute])
            ->andFilterWhere(['like', 'editorial', $this->editorial])
            ->andFilterWhere(['like', 'pais_cod_pais', $this->pais_cod_pais]);


        if ($this->biblioteca_idbiblioteca === null) {
            if (Yii::$app->session->has('selectBiblioteca')) {
                $this->biblioteca_idbiblioteca = Yii::$app->session->get('selectBiblioteca');
                $dataProvider = $this->search(Yii::$app->request->queryParams);
            }
        }
        
        return $dataProvider;
    }
}
