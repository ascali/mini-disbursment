# mini-disbursment

To begin using this app, follow the instruction to get started:

# Initial Setup
## Getting Started
1. Open `terminal` or `cmd`, then
2. Clone the repo: `git clone https://github.com/ascali/mini-disbursment.git`

## Set Up Database
1. Create database `mysql`, 
	* default database name is `tes`
	- change server host, database, username and password in `config/Database.php`

## Make Migration
1. Open `terminal` or `cmd`, then
2. Move to `mini-disbursement`
3. Type ` php Migration.php `
4. Check the table you have been migrated in database

# How to Use The Application
There are three options to run a disbursement request via command in `cmd` or `terminal`
1. ` php Disbursement.php -pshow `
2. ` php Disbursement.php -pcreate `
3. ` php Disbursement.php -pcheck -i{id_disburse} `


## How to Create Disbursement
1. Open `terminal` or `cmd`, then
2. Move to `mini-disbursement`
3. Type ` php Disbursement.php -pcreate`
	* default value are
	```php 
		$bank_code = 'bni';
    	$account_number = '1234567890';
    	$amount = 111111;
    	$remark = 'Sample remark by me';
	``` 
	- if you want change the values 
		1. in `mini-disbursement` open `Disbursement.php`
		2. change the values in function `create_disburse()`

## How to Check status Disbursement
1. Open `terminal` or `cmd`, then
2. Move to `mini-disbursement`
3. Type ` php Disbursement.php -pcheck -i{id_disburse} `

## How to show all data Disbursement
1. Open `terminal` or `cmd`, then
2. Move to `mini-disbursement`
3. Type ` php Disbursement.php -pshow `

