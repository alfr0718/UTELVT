<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Acerca del Sistema de Gestión Bibliotecaria';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-about">
    <div class="row justify-content-center">
        <div class="col-md-11 col-12">

            <div class="card card-teal card-outline">
                <div class="card-body">

                    <h4 class="mt-4">
                        <?= Html::encode($this->title) ?>
                    </h4>
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Saludos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Registrar tu Visita</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-messages-tab" data-toggle="pill" href="#custom-content-below-messages" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Solicitar un Libro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#custom-content-below-settings" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Prestar un Equipo</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                            <h2 class="text-teal mt-3"><b>Por un ambiente dinámico y enriquecedor para todos.</b> 🚀</h2>
                            <p>¡Saludos!</p>
                            <p>Nuestro objetivo es simple pero ambicioso: mejorar los procesos de la biblioteca para brindar una experiencia excepcional a cada persona que nos visite. Con el esfuerzo conjunto de nuestros compañeros y la participación activa de todos, estamos seguros de que podemos alcanzar esta meta.</p>
                            <p>¡Tu ayuda es fundamental para hacer de nuestra biblioteca el mejor lugar para aprender, investigar y crecer juntos! Gracias por ser parte de esta emocionante aventura.</p>
                            <p>Atentamente,<br>Tus compañeros de la Facultad de Ingenierías, Carrera TIC 👨‍💻</p>
                        </div>
                        <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                            <h2 class="text-teal mt-3"><b>Anímate a registrate en nuestro libro de visitas.</b> 📖</h2>

                            <p><strong>Paso 1: Inicia Sesión</strong></p>
                            <ul>
                                <li>Si eres parte del sistema SIAD, inicia sesión con tus credenciales.</li>
                                <li>Para visitantes externos, completa el formulario de registro con los siguientes datos: Usuario: CI, Contraseña: CI.</li>
                            </ul>

                            <p><strong>Paso 2: Selecciona tu Ubicación</strong></p>
                            <ul>
                                <li>Elige tu ubicación de conexión.</li>
                            </ul>

                            <p><strong>Paso 3: Registra tu Visita</strong></p>
                            <ul>
                                <li>Haz clic en "Registra tu visita" para generar un formulario con tus datos.</li>
                                <li>Revisa los detalles y envía el formulario.</li>
                            </ul>

                            <p>¡Listo! Has completado el proceso de registro de visita. Si necesitas ayuda, no dudes en contactarnos.</p>
                        </div>
                        <div class="tab-pane fade" id="custom-content-below-messages" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
                            <h2 class="text-teal mt-3"><b>Explora nuestra amplia colección de libros.</b> 📚</h2>

                            <p><strong>Paso 1: Ir al Catálogo de Libros</strong></p>
                            <ul>
                                <li>Haz clic en el recuadro de Catálogo de Libros</li>
                            </ul>

                            <p><strong>Paso 2: Búsqueda</strong></p>
                            <ul>
                                <li>Escribe los datos del libro que necesites.</li>
                                <li>También puedes usar el buscador en la barra de navegación ingresando el título del libro.</li>
                            </ul>

                            <p><strong>Paso 3: Elije el Libro</strong></p>
                            <ul>
                                <li>Haz clic sobre la imagen o el botón de tu libro deseado.</li>
                            </ul>

                            <p><strong>Paso 4: Selecciona el Ejemplar</strong></p>
                            <ul>
                                <li>Tenemos varias copias de un mismo libro, así que elige una que esté disponible.</li>
                            </ul>

                            <p><strong>Paso 5: Envía tu Solicitud</strong></p>
                            <ul>
                                <li>Revisa los detalles y envía el formulario.</li>
                                <li><b>Nota:</b> ¡Guarda la Solicitud!</li>

                            </ul>

                            <p><strong>Paso 6: Dirígete al Mostrador de Atención</strong></p>
                            <ul>
                                <li>Acércate al mostrador de atención y muestra tu Solicitud y, el libro te está esperando.</li>
                            </ul>

                            <p>¡Listo! Has completado el proceso. Si necesitas ayuda, no dudes en contactarnos.</p>

                        </div>
                        <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                            <h2 class="text-teal mt-3"><b>Solicita un equipo para realizar tus investigaciones.</b> 🖥️</h2>

                            <p><strong>Paso 1: Ir al índice de Equipos</strong></p>
                            <ul>
                                <li>Haz clic en el recuadro de Prétamo de Equipos</li>
                            </ul>

                            <p><strong>Paso 2: Elije el Equipo</strong></p>
                            <ul>
                                <li>Haz clic sobre el botón de un equipo disponible.</li>
                            </ul>

                            <p><strong>Paso 4: Envía tu Solicitud</strong></p>
                            <ul>
                                <li>Revisa los detalles y envía el formulario.</li>
                                <li><b>Nota:</b> ¡Guarda la Solicitud!</li>

                            </ul>

                            <p><strong>Paso 5: Dirígete al Mostrador de Atención</strong></p>
                            <ul>
                                <li>Acércate al mostrador de atención y muestra tu Solicitud y, el equipo te será activado.</li>
                            </ul>

                            <p>¡Listo! Has completado el proceso. Si necesitas ayuda, no dudes en contactarnos.</p>
                        </div>
                    </div>
                    <div class="tab-custom-content">

                        <p class="index-sub text-center mt-3">
                            Por favor, ayúdanos a mejorar completando nuestra encuesta.&nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-success" href="#">Empezar &raquo;</a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>