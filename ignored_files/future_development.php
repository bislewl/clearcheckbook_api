<?php

define('DATABASE_DBNAME','clearcheckbook_db');
define('DATABASE_USERNAME','clearcheckbook');
define('DATABADE_PASSWORD','password_here');


$user_savings_transaction_id = 53563832; // mine
$user_round_up = true;
$user_added_percent_credit = 1.00; // 1.00%
$user_added_percent_debit = 0.50; // 0.05% transaction_type

$transaction_id = (int)$_GET['transaction_id'];
$sql_update = "UPDATE ".DB_TANASACTION_TABLE." SET jived=1 WHERE transaction_id=".$transaction_id;

$added_amount = 0.00;

/* BOF ADDED FEATURE */
$sql_transaction = "SELECT * FROM ".DB_TANASACTION_TABLE." WHERE transaction_id=".$transaction_id;
if($user_added_percent_credit != 0 && $sql_transaction['transaction_type'] == 0){
    $added_amount = ($sql_transaction['amount']) * ($user_added_percent_credit/100);
}
if($user_added_percent_debit != 0 && $sql_transaction['transaction_type'] == 1){
    $added_amount = ($sql_transaction['amount']) * ($user_added_percent_debit/100);

}
/* EOF ADDED FEATURE */


/* BOF ROUND UP FEATURE */
$sql_transaction = "SELECT * FROM ".DB_TANASACTION_TABLE." WHERE transaction_id=".$transaction_id;
if($user_round_up == true && $sql_transaction['transaction_type'] == 0){
    $added_amount = ceil($sql_transaction['amount']) - $sql_transaction['amount'];
}
/* EOF ROUND UP FEATURE */

if($added_amount != 0.00){
    $sql_savings = "SELECT * FROM ".DB_TANASACTION_TABLE." WHERE transaction_id=".$user_savings_transaction_id;
    $new_savings_amount = $sql_savings['amount'] + $added_amount;
    $sql_update = "UPDATE ".DB_TANASACTION_TABLE." SET amount='".$new_savings_amount."' WHERE transaction_id=".$user_savings_transaction_id;
}