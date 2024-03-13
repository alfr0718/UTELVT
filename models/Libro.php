<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libro".
 *
 * @property int $id
 * @property string|null $codigo_barras
 * @property string $titulo
 * @property string $autor
 * @property string|null $isbn
 * @property string|null $cute
 * @property string $editorial
 * @property string|null $anio_publicacion
 * @property int $categoria_id
 * @property int $asignatura_id
 * @property string $pais_codigopais
 *
 * @property Asignatura $asignatura
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Categoria $categoria
 * @property Pais $paisCodigopais
 */
class Libro extends \yii\db\ActiveRecord
{
    public $cubiertaLibro;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cubiertaLibro'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['titulo', 'autor', 'editorial', 'categoria_id', 'asignatura_IdAsig', 'pais_cod_pais', 'seccion_id', 'biblioteca_idbiblioteca'], 'required'],
            [['anio_publicacion', 'cover'], 'safe'],
            [['titulo', 'autor', 'isbn', 'cute', 'editorial'], 'string', 'max' => 300],
            [['isbn', 'cute'], 'string', 'max' => 200],
            [['categoria_id', 'asignatura_IdAsig', 'seccion_id'], 'integer'],
            [['pais_cod_pais'], 'string', 'max' => 10],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [['asignatura_IdAsig'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::class, 'targetAttribute' => ['asignatura_IdAsig' => 'IdAsig']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['pais_cod_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::class, 'targetAttribute' => ['pais_cod_pais' => 'cod_pais']],
            [['seccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seccion::class, 'targetAttribute' => ['seccion_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'autor' => 'Autor',
            'isbn' => 'ISBN',
            'cute' => 'CUTE',
            'editorial' => 'Editorial',
            'anio_publicacion' => 'Año de Publicación',
            'seccion_id' => 'Sección',
            'categoria_id' => 'Categoría',
            'asignatura_IdAsig' => 'Asignatura',
            'pais_cod_pais' => 'País',
            'cover' => 'Portada',
            'biblioteca_idbiblioteca' => 'Biblioteca',
        ];
    }

    /**
     * Gets query for [[Asignatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignatura::class, ['IdAsig' => 'asignatura_IdAsig']);
    }

    /**
     * Gets query for [[Seccion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeccion()
    {
        return $this->hasOne(Seccion::class, ['id' => 'seccion_id']);
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
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[PaisCodigopais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaisCodigopais()
    {
        return $this->hasOne(Pais::class, ['cod_pais' => 'pais_cod_pais']);
    }


    /**
     * Gets query for [[Ejemplar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEjemplar()
    {
        return $this->hasMany(Ejemplar::class, ['libro_id' => 'id']);
    }

}
