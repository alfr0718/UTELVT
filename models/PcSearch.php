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



        $tipoUsuario = Yii::$app->user->identity->tipo_usuario;

        // Si el tipo de usuario es el requerido, agregar filtro adicional
        if ($tipoUsuario === User::TYPE_EXTERNO || $tipoUsuario === User::TYPE_DOCENTE|| $tipoUsuario === User::TYPE_ESTUDIANTE) {
            // Agregar filtro adicional para tipo 1
            $query->andWhere(['type' => 1]);
            $query->andWhere(['Status' => 1]);
        }

        return $dataProvider;
    }
}
