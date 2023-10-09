<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libro".
 *
 * @property int $codigo_barras
 * @property string|null $n_ejemplares
 * @property string $titulo
 * @property string $autor
 * @property string|null $isbn
 * @property string|null $cute
 * @property string $editorial
 * @property string|null $anio_publicacion
 * @property string|null $estado
 * @property string $categoria_id
 * @property string $asignatura_id
 * @property string $pais_codigopais
 * @property int $biblioteca_idbiblioteca
 *
 * @property Asignatura $asignatura
 * @property Biblioteca $bibliotecaIdbiblioteca
 * @property Categoria $categoria
 * @property Pais $paisCodigopais
 * @property Prestamo[] $prestamos
 */
class Libro extends \yii\db\ActiveRecord
{
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
            [['titulo', 'autor', 'editorial', 'categoria_id', 'asignatura_id', 'pais_codigopais', 'biblioteca_idbiblioteca'], 'required'],
            [['anio_publicacion'], 'safe'],
            [['biblioteca_idbiblioteca'], 'integer'],
            [['n_ejemplares', 'isbn', 'cute'], 'string', 'max' => 100],
            [['titulo', 'autor', 'editorial'], 'string', 'max' => 45],
            [['estado'], 'string', 'max' => 10],
            [['categoria_id', 'asignatura_id', 'pais_codigopais'], 'string', 'max' => 4],
            [['asignatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Asignatura::class, 'targetAttribute' => ['asignatura_id' => 'id']],
            [['biblioteca_idbiblioteca'], 'exist', 'skipOnError' => true, 'targetClass' => Biblioteca::class, 'targetAttribute' => ['biblioteca_idbiblioteca' => 'idbiblioteca']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['pais_codigopais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::class, 'targetAttribute' => ['pais_codigopais' => 'codigopais']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo_barras' => 'id',
            'n_ejemplares' => 'Código de Barra',
            'titulo' => 'Titulo',
            'autor' => 'Autor',
            'isbn' => 'ISBN',
            'cute' => 'CUTE',
            'editorial' => 'Editorial',
            'anio_publicacion' => 'Año de Publicación',
            'estado' => 'Estado',
            'categoria_id' => 'Categoría',
            'asignatura_id' => 'Asignatura',
            'pais_codigopais' => 'País',
            'biblioteca_idbiblioteca' => 'Ubicación',
        ];
    }

    /**
     * Gets query for [[Asignatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsignatura()
    {
        return $this->hasOne(Asignatura::class, ['id' => 'asignatura_id']);
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
        return $this->hasOne(Pais::class, ['codigopais' => 'pais_codigopais']);
    }

    /**
     * Gets query for [[Prestamos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamo::class, ['libro_codigo_barras' => 'codigo_barras', 'libro_biblioteca_idbiblioteca' => 'biblioteca_idbiblioteca']);
    }
}
