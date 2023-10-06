<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prestamo".
 *
 * @property int $id
 * @property string $fecha_solicitud
 * @property string|null $intervalo_solicitado
 * @property string $tipoprestamo_id
 * @property int $biblioteca_idbiblioteca
 * @property string|null $pc_idpc
 * @property int|null $pc_biblioteca_idbiblioteca
 * @property string|null $libro_codigo_barras
 * @property int|null $libro_biblioteca_idbiblioteca
 * @property string $personaldata_Ci
 *
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Libro $libroCodigoBarras
 * @property Pc $pcIdpc
 * @property Personaldata $personaldataCi
 * @property Tipoprestamo $tipoprestamo
 */
class Prestamo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestamo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_solicitud', 'intervalo_solicitado'], 'safe'],
            [['tipoprestamo_id', 'biblioteca_idbiblioteca', 'personaldata_Ci'], 'required'],
            [['biblioteca_idbiblioteca', 'pc_biblioteca_idbiblioteca', 'libro_biblioteca_idbiblioteca'], 'integer'],
            [['tipoprestamo_id'], 'string', 'max' => 5],
            [['pc_idpc', 'personaldata_Ci'], 'string', 'max' => 15],
            [['libro_codigo_barras'], 'string', 'max' => 100],
            [['libro_biblioteca_idbiblioteca'], 'unique'],
            [['libro_codigo_barras'], 'unique'],
            [['pc_biblioteca_idbiblioteca'], 'unique'],
            [['pc_idpc'], 'unique'],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [['libro_codigo_barras', 'libro_biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Libro::class, 'targetAttribute' => ['libro_codigo_barras' => 'codigo_barras', 'libro_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']],
            [['pc_idpc', 'pc_biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Pc::class, 'targetAttribute' => ['pc_idpc' => 'idpc', 'pc_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']],
            [['personaldata_Ci'], 'exist', 'skipOnError' => true, 'targetClass' => Personaldata::class, 'targetAttribute' => ['personaldata_Ci' => 'Ci']],
            [['tipoprestamo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprestamo::class, 'targetAttribute' => ['tipoprestamo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_solicitud' => 'Fecha de Solicitud',
            'intervalo_solicitado' => 'Intervalo',
            'tipoprestamo_id' => 'Tipo de Solicitud',
            'biblioteca_idbiblioteca' => 'Campus',
            'pc_idpc' => 'PC Solicitada',
            'pc_biblioteca_idbiblioteca' => 'Pc Biblioteca Idbiblioteca',
            'libro_codigo_barras' => 'Libro Solicitado',
            'libro_biblioteca_idbiblioteca' => 'Libro Biblioteca Idbiblioteca',
            'personaldata_Ci' => 'Solicitante',
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
     * Gets query for [[LibroCodigoBarras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibroCodigoBarras()
    {
        return $this->hasOne(Libro::class, ['codigo_barras' => 'libro_codigo_barras', 'biblioteca_idbiblioteca' => 'libro_biblioteca_idbiblioteca']);
    }

    /**
     * Gets query for [[PcIdpc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPcIdpc()
    {
        return $this->hasOne(Pc::class, ['idpc' => 'pc_idpc', 'biblioteca_idbiblioteca' => 'pc_biblioteca_idbiblioteca']);
    }

    /**
     * Gets query for [[PersonaldataCi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonaldataCi()
    {
        return $this->hasOne(Personaldata::class, ['Ci' => 'personaldata_Ci']);
    }

    /**
     * Gets query for [[Tipoprestamo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoprestamo()
    {
        return $this->hasOne(Tipoprestamo::class, ['id' => 'tipoprestamo_id']);
    }
}
