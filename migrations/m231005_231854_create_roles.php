<?php

use yii\db\Migration;

/**
 * Class m231005_231854_create_roles
 */
class m231005_231854_create_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231005_231854_create_roles cannot be reverted.\n";

        return false;
    }



    public function up()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $personal = $auth->createRole('personal');
        $auth->add($personal);
        
        // Crear el rol 'usuario' y asignarle permisos
        $docente = $auth->createRole('docente');
        $auth->add($docente);

        $estudiante = $auth->createRole('estudiante');
        $auth->add($estudiante);
        
        $externo = $auth->createRole('externo');
        $auth->add($externo);
    }

    public function down()
    {
        // Eliminar los roles si es necesario
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231005_231854_create_roles cannot be reverted.\n";

        return false;
    }
    */
}
