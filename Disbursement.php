<?php 
	error_reporting( error_reporting() & ~E_NOTICE );
	include_once 'config/Database.php';

	class Disbursement
	{
	    private $url_flip;
	    private $username;
	    private $password;

	    private $connection;
	    private $table_name;

		public $id_disburse;
		public $amount;
		public $status;
		public $account_number;
		public $beneficiary_name;
		public $remark;
		public $receipt;
		public $time_served;
	    public $fee;
	    public $timestamp;

	    public function __construct($db){
	        $this->connection = $db;
			$this->url_flip = 'https://nextar.flip.id'; 
			$this->username  = "HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41";
			$this->password= "";
			$this->table_name = 'disburses';
	    }

	    function create_disburse(){
	    	$bank_code = 'bni';
	    	$account_number = '1234567890';
	    	$amount = 111111;
	    	$remark = 'Sample remark by me';
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://nextar.flip.id/disburse",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "bank_code=$bank_code&account_number=$account_number&amount=$amount&remark=$remark",
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/x-www-form-urlencoded',
			    'Authorization: Basic '.base64_encode("$this->username:$this->password")
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			$res = json_decode($response, true);
			
			$sql = "INSERT INTO `$this->table_name` 
					(`id_disburse`, `bank_code`, `account_number`, `amount`, `fee`, `beneficiary_name`, `remark`, `time_served`, `status`, `receipt`, `timestamp`)
					VALUES 
					('".$res['id']."', '".$res['bank_code']."', '".$res['account_number']."', '".$res['amount']."', '".$res['fee']."', '".$res['beneficiary_name']."', '".$res['remark']."', '".$res['time_served']."', '".$res['status']."', '".$res['receipt']."', '".$res['timestamp']."')";

			if ($this->connection->query($sql) === TRUE) {
			    $callback = $response;
			} else {
			    $callback = "Error: " . $sql . "<br>" . $this->connection->error;
			}

			$this->connection->close();
			
			return $callback;
	    }

	    function update_disburse($id){
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://nextar.flip.id/disburse/$id",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/x-www-form-urlencoded',
			    'Authorization: Basic '.base64_encode("$this->username:$this->password")
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			
			$res = json_decode($response, true);
			
			$sql = "UPDATE `$this->table_name` SET status='".$res['status']."', receipt='".$res['receipt']."', time_served='".$res['time_served']."' WHERE id_disburse='$id'";

			if ($this->connection->query($sql) === TRUE) {
			    $callback = $res;
			} else {
			    $callback = "Error updating record: " . $this->connection->error;
			}

			$this->connection->close();
			
			return json_encode($callback);
	    }

	    function show_disburse(){
			$sql = "SELECT * FROM `$this->table_name`";
			$result = $this->connection->query($sql);

			if ($result->num_rows > 0) {
				$callback = array();
				while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
					array_push($callback, $row);
				}
			} else {
			    $callback = array("message" => "0 results");
			}

			header('Content-Type: application/json');
			return json_encode($callback, JSON_PRETTY_PRINT);
	    }
	}

	$database = new Database();
	$db = $database->getConnection();

	$disburse = new Disbursement($db);
	
	$param = getopt("p:");
	$paramId = getopt("i:");
	
	if ($param['p']=="show") {
		echo $disburse->show_disburse();
	} else if ($param['p']=="create") {
		echo $disburse->create_disburse();
	} else if ($param['p']=="check") {
		echo $disburse->update_disburse($paramId['i']);
	} else {
		echo 'choose options to run disbursment';
	}

 ?>