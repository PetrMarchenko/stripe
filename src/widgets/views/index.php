<?php

use yii\widgets\ActiveForm;

?>

<script>
    var key = '<?= $widget->key ?>';
    var image = '<?= $widget->image ?>';
    var locale = '<?= $widget->locale ?>';
    var name = '<?= $widget->name ?>';
    var description = '<?= $widget->window_description ?>';
    var amount = '<?= $widget->amount ?>';
</script>


<?php
    /**
     * @var $widget shark\widgets\Stripe;
     */
    $form = ActiveForm::begin(['id' => 'customStripeForm', 'action' => "$widget->form_action"]);
?>
    <input type="hidden" name="StripeForm[amount]" value="<?= $widget->amount ?>">
    <input type="hidden" name="StripeForm[currency]" value="<?= $widget->currency ?>">
    <input type="hidden" name="StripeForm[description]" value="<?= $widget->description ?>">
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <span id="customButton" class="btn btn-info"> <?= $widget->button_title ?> </span>
<?php ActiveForm::end(); ?>
