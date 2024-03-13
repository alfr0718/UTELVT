<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ejemplar".
 *
 * @property int $id
 * @property string $codigo_barras
 * @property string $ubicacion
 * @property int $Status
 * @property int $libro_id
 * @property int $biblioteca_idbiblioteca
 *
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Libro $libro
 */
class Ejemplar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejemplar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'codigo_barras', 'ubicacion', 'Status', 'libro_id', 'biblioteca_idbiblioteca'], 'required'],
            [['id', 'Status', 'libro_id', 'biblioteca_idbiblioteca'], 'integer'],
            [['codigo_barras', 'ubicacion'], 'string', 'max' => 60],
            [['id'], 'unique'],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [['libro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Libro::class, 'targetAttribute' => ['libro_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo_barras' => 'Codigo Barras',
            'ubicacion' => 'Ubicacion',
            'Status' => 'Status',
            'libro_id' => 'Libro ID',
            'biblioteca_idbiblioteca' => 'Biblioteca Idbiblioteca',
        ];
    }

    /**
     * Gets query for [[BibliotecaIdbiblioteca]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBibliotecaIdbiblioteca()
    {
        return $this->hasOne(Biblioteca::class, ['idbiblioteca' => 'biblioteca_idbiblioteca']);
    }

    /**
     * Gets query for [[Libro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libro::class, ['id' => 'libro_id']);
    }
}
