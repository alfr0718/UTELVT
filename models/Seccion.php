<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seccion".
 *
 * @property int $id
 * @property string $NombreSeccion
 * @property string|null $CodeSeccion
 * @property string|null $ColorSeccion
 *
 * @property Libro[] $libros
 */
class Seccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'NombreSeccion'], 'requ
            ired'],
            [['id'], 'integer'],
            [['NombreSeccion'], 'string', 'max' => 60],
            [['CodeSeccion'], 'string', 'max' => 6],
            [['NombreSeccion'], 'string', 'max' => 45],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'NombreSeccion' => 'Nombre',
            'CodeSeccion' => 'Código',
            'ColorSeccion'=>'Color'
        ];
    }

    /**
     * Gets query for [[Libros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibros()
    {
        return $this->hasMany(Libro::class, ['seccion_id' => 'id']);
    }
}
