<?php
use shark\models\Stripe as StripeModel;
/**
 * @var $stripeModel StripeModel
 */
?>

<h1> <?= $messages ?></h1>
<?php if (isset($stripeModel)): ?>
    <h2> Amount: <?= $stripeModel->amount ?></h2>
<?php endif ?>
