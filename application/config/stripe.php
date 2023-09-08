<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Stripe API Configuration
| -------------------------------------------------------------------
|
| You will get the API keys from Developers panel of the Stripe account
| Login to Stripe account (https://dashboard.stripe.com/)
| and navigate to the Developers » API keys page
|
|  stripe_api_key        	string   Your Stripe API Secret key.
|  stripe_publishable_key	string   Your Stripe API Publishable key.
|  stripe_currency   		string   Currency code.
*/
$config['stripe_api_key']         = 'sk_test_51I6GSHLUSYuzsidDfBCk7RJz95o2MRcRHTJkAf2nv6Y2bxWTwzwUibzzoeLv2za6WXOKkOAghQZgWKLBm8WQlczn00gENLjmPs'; 
$config['stripe_publishable_key'] = 'pk_test_51I6GSHLUSYuzsidD2PPZytSUJAuDZ8ZBVUhJAhRVMvc1P9wKeQred18JhbLu4lp8hAF4SDVKXjcyIprFDH7JuDVB00tG1g4bVK'; 
$config['stripe_currency']        = 'usd';