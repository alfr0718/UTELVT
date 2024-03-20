<?php

namespace app\commands;

use app\models\Ejemplar;
use app\models\Pc;
use yii\console\Controller;
use app\models\Prestamo;

class UpdateStatusController extends Controller
{
    public function actionActualizarSolicitud()
    {
        $prestamos = Prestamo::find()
            ->where(['<', 'fechaentrega', date('Y-m-d H:i:s')])
            ->andWhere(['Status' => 1])
            ->all();

        foreach ($prestamos as $prestamo) {

            if ($prestamo->tipoprestamo_id === 'LIB') {
                $ejemplar = Ejemplar::findOne($prestamo->object_id);
                if ($ejemplar !== null) {
                    $ejemplar->Status = 1;
                    $ejemplar->save(false);
                }
            } elseif ($prestamo->tipoprestamo_id === 'COMP') {
                $equipo = Pc::findOne($prestamo->object_id);
                if ($equipo !== null) {
                    $equipo->Status = 1;
                    $equipo->save(false);
                }
            }

            $prestamo->Status = 0;
            $prestamo->save(false);
        }

        echo "Estado de los ejemplares actualizado correctamente.\n";
    }
}
