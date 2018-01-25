    <?php
    class db {
        protected $status;
    	protected $conn;
    	protected $host;
    	protected $user;
    	protected $password;
    	protected $baseName;
    	protected $port;
    	protected $Debug;
        
     
        function __construct($params=array()) {
    		$this->conn = false;
    		$this->host = '127.0.0.1'; //hostname
    		$this->user = 'root'; //username
    		$this->password = ''; //password
    		$this->baseName = 'personne'; //name of your database
    		$this->port = '3306';
    		$this->debug = true;
            $this->status = 4;
    	}
     
    	function __destruct() {
            
            $this->disconnect();
    	}
    	
    	function connect() {
    		if (!$this->conn) {
    			try {
    				$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->baseName.'', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));  
    			}
    			catch (Exception $e) {
    				//die('Erreur : ' . $e->getMessage());
    			}
     
    			if (!$this->conn) {
    				$this->status = 0; 
                    //die();                    
    			} 
    			else {
    				$this->status = 1;
    			}
    		}
            
    		return $this->conn;
    	}
     
    	function disconnect() {

    		if ($this->conn) {
    			$this->conn = null;
    		}

            if (!$this->conn && $this->status != 0) {
                $this->status =  2; 
            } 

    	}
    
    	function getOne($query) {
    		$result = $this->conn->prepare($query);
    		$ret = $result->execute();
    		if (!$ret) {
    		   echo 'PDO::errorInfo():';
    		   echo '<br />';
    		   echo 'error SQL: '.$query;
    		   die();
    		}
    		$result->setFetchMode(PDO::FETCH_ASSOC);
    		$reponse = $result->fetch();
    		
    		return $reponse;
    	}
    	
    	function getAll($query) {
    		$result = $this->conn->prepare($query);
    		$ret = $result->execute();
    		if (!$ret) {
    		   echo 'PDO::errorInfo():';
    		   echo '<br />';
    		   echo 'error SQL: '.$query;
    		   die();
    		}
    		$result->setFetchMode(PDO::FETCH_ASSOC);
    		$reponse = $result->fetchAll();
    		
    		return $reponse;
    	}
    	
    	function execute($query) {
    		if (!$response = $this->conn->exec($query)) {
    		  echo 'PDO::errorInfo():';
    		   echo '<br />';
    		   echo 'error SQL: '.$query;
    		   die();
    		}
    		return $response;
    	}

        function status() {
            if($this->status == 0)
            echo  "Status : Connection To MySql Failed [Check The Connection Infos] <br>"; 
             else if($this->status == 1)
            echo  "Status : Connected  To MySql <br>";
                else if($this->status == 2)
            echo  "Status : Disconnection To MySql Succeded <br>"; 
                else if($this->status == 4)
            echo  "Status : Not Connected To MySql Yet <br>"; 
        }

    }