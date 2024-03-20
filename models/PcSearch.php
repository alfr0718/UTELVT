<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pc;
use Yii;

/**
 * PcSearch represents the model behind the search form of `app\models\Pc`.
 */
class PcSearch extends Pc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idpc', 'nombre', 'Status', 'type'], 'safe'],
            [['biblioteca_idbiblioteca'], 'integer'],
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
        $query = Pc::find();

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
            'biblioteca_idbiblioteca' => $this->biblioteca_idbiblioteca,
            'Status' => $this->Status,
            'type' => $this->type,            
        ]);

        $query->andFilterWhere(['like', 'idpc', $this->idpc])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);


        // Aplicar filtros adicionales basados en el tipo de usuario
        $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

        if ($tipoUsuario === User::TYPE_EXTERNO || $tipoUsuario === User::TYPE_ESTUDIANTE || $tipoUsuario === User::TYPE_DOCENTE) {
            $query->andWhere(['Status' => 1]);
        }

        if ($tipoUsuario === User::TYPE_EXTERNO || $tipoUsuario === User::TYPE_ESTUDIANTE) {
            $query->andWhere(['type' => 1]);

        }


        if ($this->biblioteca_idbiblioteca === null && Yii::$app->session->has('selectBiblioteca')) {
            $this->biblioteca_idbiblioteca = Yii::$app->session->get('selectBiblioteca');
            $dataProvider = $this->search(Yii::$app->request->queryParams);
        }

        return $dataProvider;
    }
}
