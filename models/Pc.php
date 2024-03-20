<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pc".
 *
 * @property int $idpc
 * @property string $nombre
 * @property int $Status
 * @property int $type
 * @property int $biblioteca_idbiblioteca
 *
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Prestamo[] $prestamos
 */
class Pc extends \yii\db\ActiveRecord
{
    public $typeArray = [
        1 => 'Computador de Escritorio',
        2 => 'Ordenador Portátil',
        3 => 'Proyector'
    ];

    public $statusArray = [
        '2' => 'En Uso',
        '1' => 'Disponible',
        '0' => 'No Disponible',
    ];

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
            [['nombre', 'biblioteca_idbiblioteca'], 'required'],
            [['Status', 'type', 'biblioteca_idbiblioteca'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
            // [['idpc', 'biblioteca_idbiblioteca'], 'unique', 'targetAttribute' => ['idpc', 'biblioteca_idbiblioteca']],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idpc' => 'Código',
            'nombre' => 'Nombre',
            'type' => 'Tipo de Equipo',
            'Status' => 'Estado',
            'biblioteca_idbiblioteca' => 'Ubicación',
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
