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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cedula_solicitante', 'intervalo_solicitado', 'fecha_solicitud', 'fechaentrega', 'Status'], 'safe'],
            [['tipoprestamo_id', 'biblioteca_idbiblioteca'], 'required'],
            [['biblioteca_idbiblioteca', /*'pc_idpc', 'pc_biblioteca_idbiblioteca', 'libro_id', 'libro_biblioteca_idbiblioteca'*/], 'integer'],
            [['tipoprestamo_id'], 'string', 'max' => 5],
            [['personaldata_Ci', 'informacionpersonal_d_CIInfPer', 'informacionpersonal_CIInfPer'], 'string', 'max' => 15],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [
                ['informacionpersonal_CIInfPer'], 'exist', 'skipOnError' => true,
                'targetClass' => Informacionpersonal::class,
                'targetAttribute' => ['informacionpersonal_CIInfPer' => 'CIInfPer'],
                'when' => function ($model) {
                    return !empty($model->informacionpersonal_CIInfPer);
                },
                'message' => 'NO EXISTE TAL ESTUDIANTE.'
            ],
            [
                ['informacionpersonal_d_CIInfPer'],
                'exist',
                'skipOnError' => true,
                'targetClass' => InformacionpersonalD::class,
                'targetAttribute' => ['informacionpersonal_d_CIInfPer' => 'CIInfPer'],
                'when' => function ($model) {
                    return !empty($model->informacionpersonal_d_CIInfPer);
                },
                'message' => 'NO EXISTE TAL PERSONAL UNIVERSITARIO.'
            ],
            // [['libro_id', 'libro_biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Libro::class, 'targetAttribute' => ['libro_id' => 'id', 'libro_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']],
            // [['pc_idpc', 'pc_biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Pc::class, 'targetAttribute' => ['pc_idpc' => 'idpc', 'pc_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']],
            [
                ['personaldata_Ci'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Personaldata::class,
                'targetAttribute' => ['personaldata_Ci' => 'Ci'],
                'when' => function ($model) {
                    return !empty($model->personaldata_Ci);
                },
                'message' => 'NO EXISTE TAL INDIVIDUO EN EL SISTEMA.'
            ],
            [['tipoprestamo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprestamo::class, 'targetAttribute' => ['tipoprestamo_id' => 'id']],
            [
                ['cedula_solicitante', 'personaldata_Ci', 'informacionpersonal_d_CIInfPer', 'informacionpersonal_CIInfPer'],
                'required',
                'when' => function ($model) {
                    return empty($model->cedula_solicitante)
                        && empty($model->personaldata_Ci)
                        && empty($model->informacionpersonal_d_CIInfPer)
                        && empty($model->informacionpersonal_CIInfPer);
                },
                'whenClient' => "function (attribute, value) {
                return $('#cedula_solicitante').val() == '' && $('#personaldata_Ci').val() == '' && $('#informacionpersonal_d_CIInfPer').val() == '' && $('#informacionpersonal_CIInfPer').val() == '';
            }",
                'message' => 'INGRESE AL MENOS UNO.'
            ],
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
            'biblioteca_idbiblioteca' => 'Ubicación',
            'cedula_solicitante' => '¡Tus Datos!',
            'personaldata_Ci' => 'Cédula Solicitante Externo',
            'informacionpersonal_d_CIInfPer' => 'Cédula Docente',
            'informacionpersonal_CIInfPer' => 'Cédula Estudiante',
            'pc_idpc' => 'Equipo',
            //'pc_biblioteca_idbiblioteca' => 'Ubicación del Equipo',
            'libro_id' => 'Libro',
            //'libro_biblioteca_idbiblioteca' => 'Ubicación del Libro',
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
     * Gets query for [[Ejemplar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEjemplar()
    {
        return $this->hasOne(Ejemplar::class, ['id' => 'object_id']);
    }

    /**
     * Gets query for [[PcIdpc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPcIdpc()
    {
        return $this->hasOne(Pc::class, ['idpc' => 'object_id']);
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
     * Gets query for [[InformacionpersonalDCIInfPer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInformacionpersonalDCIInfPer()
    {
        return $this->hasOne(InformacionpersonalD::class, ['CIInfPer' => 'informacionpersonal_d_CIInfPer']);
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
