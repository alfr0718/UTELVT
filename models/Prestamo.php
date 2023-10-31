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
 * @property string|null $personaldata_Ci
 * @property string|null $informacionpersonal_d_CIInfPer
 * @property string|null $informacionpersonal_CIInfPer
 * @property int|null $pc_idpc
 * @property int|null $pc_biblioteca_idbiblioteca
 * @property int|null $libro_id
 * @property int|null $libro_biblioteca_idbiblioteca
 *
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Informacionpersonal $informacionpersonalCIInfPer
 * @property InformacionpersonalD $informacionpersonalDCIInfPer
 * @property Libro $libro
 * @property Pc $pcIdpc
 * @property Personaldata $personaldataCi
 * @property Tipoprestamo $tipoprestamo
 */

class Prestamo extends \yii\db\ActiveRecord
{
    public $intervalo_solicitado;
    public $cedula_solicitante;
    public $field_choice;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestamo';
    }

    public function rules()
    {
        return [
            [['fecha_solicitud', 'cedula_solicitante', 'intervalo_solicitado', 'fechaentrega'], 'safe'],
            [['tipoprestamo_id', 'biblioteca_idbiblioteca'], 'required'],
            [['biblioteca_idbiblioteca', 'pc_idpc', 'pc_biblioteca_idbiblioteca', 'libro_id', 'libro_biblioteca_idbiblioteca'], 'integer'],
            [['tipoprestamo_id'], 'string', 'max' => 5],
            [['personaldata_Ci', 'informacionpersonal_d_CIInfPer', 'informacionpersonal_CIInfPer'], 'string', 'max' => 15],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [['informacionpersonal_CIInfPer'], 'exist', 'skipOnError' => true, 'targetClass' => Informacionpersonal::class, 'targetAttribute' => ['informacionpersonal_CIInfPer' => 'CIInfPer']],
            [['informacionpersonal_d_CIInfPer'], 'exist', 'skipOnError' => true, 'targetClass' => InformacionpersonalD::class, 'targetAttribute' => ['informacionpersonal_d_CIInfPer' => 'CIInfPer']],
            [['libro_id', 'libro_biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Libro::class, 'targetAttribute' => ['libro_id' => 'id', 'libro_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']],
            [['personaldata_Ci'], 'exist', 'skipOnError' => true, 'targetClass' => Personaldata::class, 'targetAttribute' => ['personaldata_Ci' => 'Ci']],
            [['tipoprestamo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprestamo::class, 'targetAttribute' => ['tipoprestamo_id' => 'id']],
            [['personaldata_Ci', 'informacionpersonal_d_CIInfPer', 'informacionpersonal_CIInfPer'], 'default', 'value' => null],
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
            'fechaentrega' => 'Fecha de Entrega',
            'tipoprestamo_id' => 'Tipo de Solicitud',
            'intervalo_solicitado' => 'Tiempo Solicitado',
            'biblioteca_idbiblioteca' => 'Campus',
            'cedula_solicitante' => '¡Tus Datos!',
            'personaldata_Ci' => 'Cédula Solicitante Externo',
            'informacionpersonal_d_CIInfPer' => 'Cédula Docente',
            'informacionpersonal_CIInfPer' => 'Cédula Estudiante',
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
     * Gets query for [[InformacionpersonaDCIInfPer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInformacionpersonaDCIInfPer()
    {
        return $this->hasOne(InformacionpersonalD::class, ['CIInfPer' => 'informacionpersonal_d_CIInfPer']);
    }

    /**
     * Gets query for [[InformacionpersonalCIInfPer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInformacionpersonalCIInfPer()
    {
        return $this->hasOne(Informacionpersonal::class, ['CIInfPer' => 'informacionpersonal_CIInfPer']);
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
