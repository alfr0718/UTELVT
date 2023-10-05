<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pc".
 *
 * @property string $idpc
 * @property string $estado
 * @property int $biblioteca_idbiblioteca
 *
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Prestamo[] $prestamos
 */
class Pc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idpc', 'estado', 'biblioteca_idbiblioteca'], 'required'],
            [['biblioteca_idbiblioteca'], 'integer'],
            [['idpc'], 'string', 'max' => 15],
            [['estado'], 'string', 'max' => 10],
            [['idpc', 'biblioteca_idbiblioteca'], 'unique', 'targetAttribute' => ['idpc', 'biblioteca_idbiblioteca']],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idpc' => 'Idpc',
            'estado' => 'Estado',
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
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamo::class, ['pc_idpc' => 'idpc', 'pc_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']);
    }
}
