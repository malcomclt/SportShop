<?php
require_once('../vendor/autoload.php');
$cle_stripe = "Votre clé stripe"

\Stripe\Stripe::setApiKey($cle_stripe);

$stripe = new \Stripe\StripeClient(
  ['api_key' => $cle_stripe]
);

?>