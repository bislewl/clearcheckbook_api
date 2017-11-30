# ClearCheckbook.com API - PHP Class #

*This has been tested using PHP 7 and appears to work well. However use at your own risk.*

There are several items that still need to be completed but this is just a basic start.

1. First thing you will need is developer credentials. You can obtain these at at: https://www.clearcheckbook.com/developer It may be helpful to also have the [API Documentation](https://www.clearcheckbook.com/developer/api)
1. Next thing is to put these files on a server (local or remote)
1. Add the API credentials to the includes/configure.php file along with your username & password for ClearCheckbook.com
1. Create your file you wish to use the class in
1. Add a require() for both the 'includes/configure.php' and 'includes/classes/clearcheckbook_api.php' see example.php if needed
1. Now you can use it as a typical class. 

## Example Usages: ##
**Creating Instance:** 
```PHP
$ccb_api = new clearcheckbook_api();
```

**Get User Information:**
```PHP
$user_details = $ccb_api->getUser();
echo var_dump($user_details);
```

**Get 50 Most Recent Transactions:**
```PHP
$transaction = array('limit' => 50);
echo var_dump($ccb_api->getTransactions());
```

### @TODO List ###
- [X] Create gitHub Repo
- [ ] Provide Instructions
- [X] Create Class
- [ ] Add Functions
    - [X] _construct
    - [X] apiRequest
    - [X] getUser
    - [ ] insertUser
    - [X] getAccounts
    - [X] getAccount
    - [X] insertAccount
    - [ ] editAccount
    - [ ] deleteAccount
    - [ ] getCategories
    - [ ] insertCategory
    - [ ] editCategory
    - [ ] deleteCategory
    - [X] getTransactions
    - [X] getTransaction
    - [X] editTransaction **Need to add support for file attachments and split functionality*
    - [X] insertTransaction **Need to add support for file attachments and split functionality*
    - [X] deleteTransaction
    - [ ] editJive
    - [ ] getHistory
    - [X] getAutocomplete
    - [ ] Reports Functions
    - [ ] Budgets Functions
    - [ ] Reminders Functions
    - [ ] Bill Tracker Functions
    - [ ] Premium Status Functions
    - [ ] Currency Codes
    
Any issues? [Create an Issue](https://github.com/bislewl/clearcheckbook_api/issues/new)

Have suggestions/Improvements please fork and perform a pull request.
    
     
