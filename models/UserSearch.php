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
            [['username', 'password', 'Auth_key', 'Created_at', 'Updated_at', 'Temporalpassword', 'Tempralpasswordtime'], 'safe'],
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
            'Created_at' => $this->Created_at,
            'Updated_at' => $this->Updated_at,
            'Tempralpasswordtime' => $this->Tempralpasswordtime,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'Auth_key', $this->Auth_key])
            ->andFilterWhere(['like', 'Temporalpassword', $this->Temporalpassword]);

        return $dataProvider;
    }
}
