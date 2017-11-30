<?php

// https://www.clearcheckbook.com/developer/api

class clearcheckbook_api
{
    public function __construct()
    {
        $this->username = base64_encode(CLEARCHECKBOOK_USERNAME);
        $this->password = base64_encode(CLEARCHECKBOOK_PASSWORD);
        $this->api_ref = base64_encode(CLEARCHECKBOOK_APP_REF);
    }

    public function apiRequest($function, $params = array())
    {
        $function = preg_split('/(?=[A-Z])/', $function);
        switch ($function[0]) {
            case 'insert':
                $method = "POST";
                break;
            case 'edit':
                $method = "PUT";
                break;
            case 'delete':
                $method = "DELETE";
                break;
            case 'get':
            default:
                $method = "GET";
                break;
        }

        $call = strtolower($function[1]);
        $url = 'https://' . $this->username . ':' . $this->password . '@www.clearcheckbook.com/api/2.5/' . $call . '/?app_reference=' . $this->api_ref;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if (isset($params) && is_array($params) && count($params) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        $response = curl_exec($curl);
        curl_close($curl);
        $return = json_decode($response, true);
        if (!$response) {
            $return['error_msg'] = "Connection Failure";
            $return['status'] = false;
        }

        return $return;
    }

    // USERS

    // getUser - Gets the details for the current user.
    public function getUser()
    {
        $return = $this->apiRequest(__FUNCTION__);
        return $return;
    }

    // insertUser - Adds a new user to ClearCheckbook @todo add Function
    public function insertUser()
    {

    }

    // Accounts

    // getAccounts - Gets all of the current user's accounts
    public function getAccounts($is_overview = false)
    {
        $request['is_overview'] = $is_overview;
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // getAccount - Gets a single account
    public function getAccount($id)
    {
        $request['id'] = $id;
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // insertAccount - Adds an account for the current user
    public function insertAccount($name, $type_id, $balance = 0.00, $currency = 'USD')
    {
        $request['name'] = $name;
        $request['type_id'] = $type_id;
        if (isset($balance) && $balance != '') $request['initial_balance'] = $balance;
        if (isset($currency) && $currency != '') $request['currency_id'] = $balance;
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // editAccount - Edits a current user's account @todo add Function
    public function editAccount()
    {

    }

    // deleteAccount - Deletes a current user's account @todo add Function
    public function deleteAccount()
    {

    }

    // Categories

    //  getCategories - Gets the current user's categories @todo add Function
    public function getCategories()
    {

    }

    // insertCategory - Adds a category for the current user @todo add Function
    public function insertCategory()
    {

    }

    // editCategory - Edits a category for the current user @todo add Function
    public function editCategory()
    {

    }

    // deleteCategory - Deletes a category for the current user @todo add Function
    public function deleteCategory()
    {

    }

    //Transactions

    // getTransactions - Gets all of the current user's transactions
    public function getTransactions($params = array())
    {
        $request = array();
        if (isset($params['account_id']) && $params['account_id'] != '') $request['account_id'] = $params['account_id'];
        if (isset($params['created_at']) && $params['created_at'] != '') $request['created_at'] = $params['created_at'];
        if (isset($params['from_id']) && $params['from_id'] != '') $request['from_id'] = $params['from_id'];
        if (isset($params['created_at_time']) && $params['created_at_time'] != '') $request['created_at_time'] = $params['created_at_time'];
        if (isset($params['created_at_timezone']) && $params['created_at_timezone'] != '') $request['created_at_timezone'] = $params['created_at_timezone'];
        if (isset($params['page']) && $params['page'] != '') $request['page'] = $params['page'];
        if (isset($params['limit']) && $params['limit'] != '') $request['limit'] = $params['limit'];
        if (isset($params['order']) && $params['order'] != '') {
            $order_vars = array('date', 'created_at', 'amount', 'account', 'category', 'description', 'memo', 'payee', 'check_num');
            $order = strtolower($params['order']);
            if (in_array($order, $order_vars)) {
                $request['order'] = $params['order'];
            }
        }

        if (isset($params['order_direction']) && $params['order_direction'] != '') {
            $order_dir_vars = array('ASC', 'DESC');
            $order_dir = strtoupper($params['order_direction']);
            if (in_array($order_dir, $order_dir_vars)) {
                $request['order_direction'] = $params['order_direction'];
            }
        }

        if (isset($params['separate_splits']) && $params['separate_splits'] != '') $request['separate_splits'] = $params['separate_splits'];

        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // getTransaction - Gets a single transaction for the current user
    public function getTransaction($id)
    {
        $request['id'] = $id;
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // editTransaction - Edits a current user's transaction
    public function editTransaction($params)
    {
        $request['id'] = $params['id'];
        $request['date'] = $params['date'];
        $request['amount'] = (float)$params['amount'];
        $request['transaction_type'] = $params['transaction_type']; // (0= Withdrawal, 1= Deposit, 3= Transfer)
        $request['account_id'] = (isset($params['account_id']) && $params['account_id'] != 0) ? (int)$params['account_id'] : 0;
        $request['category_id'] = (isset($params['category_id']) && $params['category_id'] != 0) ? (int)$params['category_id'] : 0;
        if (isset($params['description']) && $params['description'] != '') $request['description'] = $params['description'];
        $request['jive'] = (isset($params['jive']) && $params['jive'] != 0) ? $params['jive'] : 0;
        if (isset($params['from_account_id']) && $params['from_account_id'] != 0) $request['from_account_id'] = $params['from_account_id'];
        if (isset($params['to_account_id']) && $params['to_account_id'] != 0) $request['to_account_id'] = $params['to_account_id'];
        if (isset($params['check_num']) && $params['check_num'] != '') $request['check_num'] = $params['check_num'];
        if (isset($params['memo']) && $params['memo'] != '') $request['memo'] = $params['memo'];
//        $request['file_attachment'] = ''; // @todo make this work
        if (isset($params['payee']) && $params['payee'] != '') $request['payee'] = $params['payee'];
//        $request['split_amounts'] = '' // @todo make this work
//        $request['split_categories'] = '' // @todo make this work
//        $request['split_descriptions'] = '' // @todo make this work
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // insertTransaction - Adds a transaction for the current user
    public function insertTransaction($params)
    {
        $request['date'] = $params['date'];
        $request['amount'] = (float)$params['amount'];
        $request['transaction_type'] = $params['transaction_type']; // (0= Withdrawal, 1= Deposit, 3= Transfer)
        $request['account_id'] = (isset($params['account_id']) && $params['account_id'] != 0) ? (int)$params['account_id'] : 0;
        $request['category_id'] = (isset($params['category_id']) && $params['category_id'] != 0) ? (int)$params['category_id'] : 0;
        if (isset($params['description']) && $params['description'] != '') $request['description'] = $params['description'];
        $request['jive'] = (isset($params['jive']) && $params['jive'] != 0) ? $params['jive'] : 0;
        if (isset($params['from_account_id']) && $params['from_account_id'] != 0) $request['from_account_id'] = $params['from_account_id'];
        if (isset($params['to_account_id']) && $params['to_account_id'] != 0) $request['to_account_id'] = $params['to_account_id'];
        if (isset($params['check_num']) && $params['check_num'] != '') $request['check_num'] = $params['check_num'];
        if (isset($params['memo']) && $params['memo'] != '') $request['memo'] = $params['memo'];
//        $request['file_attachment'] = ''; // @todo make this work
        if (isset($params['payee']) && $params['payee'] != '') $request['payee'] = $params['payee'];
//        $request['split_amounts'] = '' // @todo make this work
//        $request['split_categories'] = '' // @todo make this work
//        $request['split_descriptions'] = '' // @todo make this work
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // deleteTransaction - Deletes a transaction for the current user
    public function deleteTransaction($id)
    {
        $request['id'] = $id;
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // editJive - Changes the jive status of a transaction for the current user @todo add Function
    public function editJive()
    {

    }

    // getHistory - List of all modified transactions for current user @todo add Function
    public function getHistory()
    {

    }


    // Autocomplete

    // Returns list of descriptions, memos or payees matching the given query
    function getAutocomplete($params)
    {
        $request['type'] = $params['type'];
        $request['query'] = $params['query'];
        $return = $this->apiRequest(__FUNCTION__, $request);
        return $return;
    }

    // @todo Add More Functions
    // Reports
    // Budgets
    // Reminders
    // Bill Tracker
    // Premium Status
    // Currency Codes
}
