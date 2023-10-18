<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prestamo".
 *
 * @property int $id
 * @property string $fecha_solicitud
 * @property string|null $fechaentrega
 * @property string $tipoprestamo_id
 * @property int $biblioteca_idbiblioteca
 * @property string $personaldata_Ci
 * @property string|null $pc_idpc
 * @property int|null $pc_biblioteca_idbiblioteca
 * @property int|null $libro_id
 * @property int|null $libro_biblioteca_idbiblioteca
 *
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Libro $libro
 * @property Pc $pcIdpc
 * @property Personaldata $personaldataCi
 * @property Tipoprestamo $tipoprestamo
 */
class Prestamo extends \yii\db\ActiveRecord
{
    public $intervalo_solicitado;
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
            [['fecha_solicitud', 'intervalo_solicitado', 'fechaentrega'], 'safe'],
            [['tipoprestamo_id', 'biblioteca_idbiblioteca', 'personaldata_Ci'], 'required'],
            [['biblioteca_idbiblioteca', 'pc_biblioteca_idbiblioteca', 'libro_id', 'libro_biblioteca_idbiblioteca'], 'integer'],
            [['tipoprestamo_id'], 'string', 'max' => 5],
            [['personaldata_Ci', 'pc_idpc'], 'string', 'max' => 15],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [['libro_id', 'libro_biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Libro::class, 'targetAttribute' => ['libro_id' => 'id', 'libro_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']],
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
            'fechaentrega' => 'Fecha de entrega',
            'tipoprestamo_id' => 'Tipo de préstamo',
            'intervalo_solicitado' => 'Tiempo Solicitado',
            'biblioteca_idbiblioteca' => 'Campus',
            'personaldata_Ci' => 'Cedula Solicitante',
            'pc_idpc' => 'Computador',
            'pc_biblioteca_idbiblioteca' => 'Ubicación del Computador',
            'libro_id' => 'Libro',
            'libro_biblioteca_idbiblioteca' => 'Ubicación del Libro',
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
        return $this->hasOne(Libro::class, ['id' => 'libro_id', 'biblioteca_idbiblioteca' => 'libro_biblioteca_idbiblioteca']);
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
