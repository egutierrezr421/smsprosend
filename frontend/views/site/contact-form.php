<?php
/**
 * Created by PhpStorm.
 * User: Nety
 * Date: 16/04/2022
 * Time: 12:53 AM
 */

use yii\helpers\Url;
use frontend\components\bootstrap4\ActiveForm;
use frontend\models\ContactForm;
use yii\widgets\Pjax;

?>

<?php
    Pjax::begin(['enablePushState' => false]);
    $model_contact = new ContactForm();
    $contact_form = ActiveForm::begin([
        'action' => ['/site/contact'],
        'options' => [
            'data-pjax' => 1
        ]
    ]);
?>
    <div class="row text-center text-md-start">
        <p class="color-white-kubacel">¿Qué crees de nuestros servicios?</p>
        <div class="col-12 col-md-6 mb-3">
            <div class="mb-3">
                <?= $contact_form->field($model_contact, 'message')->textarea(['class'=>"form-control form-control-footer-kubacel", 'placeholder'=>"Escribe aquí", 'rows'=>6])->label(false) ?>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="mb-3">
                <?= $contact_form->field($model_contact, 'name')->textInput(['class'=>"form-control form-control-footer-kubacel mb-3", 'placeholder'=>"Nombre"])->label(false) ?>
            </div>
            <div class="mb-3">
                <?= $contact_form->field($model_contact, 'email')->textInput(['class'=>"form-control form-control-footer-kubacel mb-3", 'placeholder'=>"Correo electrónico"])->label(false) ?>
            </div>
            <div class="mb-3">
                <?= $contact_form->field($model_contact, 'phone')->textInput(['class'=>"form-control form-control-footer-kubacel mb-3", 'placeholder'=>"Teléfono"])->label(false) ?>
            </div>
            <div class="d-grid gap-2">
                <button id="btn-contact" class="btn btn-primary mt-3" type="submit">Enviar comentario</button>
            </div>

            <?php
            if(isset($result['success'])) {
                echo '<div class="mt-3">';
                if($result['success']) {
                    echo '<div class="text-success">'.$result['message'].'</div>';
                } else {
                    echo '<div class="text-danger">'.$result['message'].'</div>';
                }
                echo '</div>';
            }
            ?>

        </div>
    </div>


<?php
    ActiveForm::end();
    Pjax::end();
?>