<?php
    class Quote {
        //DB stuff
        private $conn;
        private $table = 'quotes';

        //Quote Properties
        public $id;
        public $quote;
        public $category;
        public $author;
        public $author_id;
        public $category_id;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //Get Quotes
        public function read() {
            //Create query
            $query = "SELECT 
            a.author as author,
            c.category as category,
            q.quote, 
            q.id
            FROM 
                {$this->table} q
            LEFT JOIN 
                authors a ON author_id = a.id
            LEFT JOIN
                categories c ON category_id = c.id";

        //Prepared statements
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
            
        }

        //Get single quote
        public function read_single() {
            
            if(isset($_GET['id'])){
             //Create query
             $query = "SELECT 
             a.author as author,
             c.category as category,
             q.quote,
             q.id
             FROM 
                  {$this->table} q
             LEFT JOIN 
                 authors a ON author_id = a.id
             LEFT JOIN
                 categories c ON category_id = c.id
             WHERE
             q.id = :id";

            //Prepared statements
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(':id', $this->id);

            //Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if( is_array($row) ) {

                $this->id = $row['id'];
                $this->quote = $row['quote'];
                $this->author = $row['author'];
                $this->category = $row['category'];

                return $row;
                
            } else{
                echo json_encode(
                    array('message' => 'No Quotes Found')
                );
                exit();
            }

            }
            else if (isset($_GET['author_id']) and isset($_GET['category_id'])){
                //Create query
                $query = "SELECT 
                a.author as author,
                c.category as category,
                q.quote,
                q.id
                FROM 
                     {$this->table} q
                LEFT JOIN 
                    authors a ON author_id = a.id
                LEFT JOIN
                    categories c ON category_id = c.id
                WHERE
                q.author_id = :author_id AND q.category_id = :category_id";

                //Prepared statements
                $stmt = $this->conn->prepare($query);

                //Bind ID
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id', $this->category_id);

                //Execute query
                $stmt->execute();
                
                if($stmt)  {

                    return $stmt;
                    
                } else{
                    echo json_encode(
                        array('message' => 'No Quotes Found')
                    );
                    exit();
                }
            }


            else if (isset($_GET['author_id'])){
                //Create query
                $query = "SELECT 
                a.author as author,
                c.category as category,
                q.quote,
                q.id
                FROM 
                     {$this->table} q
                LEFT JOIN 
                    authors a ON author_id = a.id
                LEFT JOIN
                    categories c ON category_id = c.id
                WHERE
                q.author_id = :author_id";

                //Prepared statements
                $stmt = $this->conn->prepare($query);

                //Bind ID
                $stmt->bindParam(':author_id', $this->author_id);

                //Execute query
                $stmt->execute();

                if($stmt)  {

                    return $stmt;
                    
                } else{
                    echo json_encode(
                        array('message' => 'No Quotes Found')
                    );
                    exit();
                }
            }
            else if (isset($_GET['category_id'])){
                //Create query
                $query = "SELECT 
                a.author as author,
                c.category as category,
                q.quote,
                q.id
                FROM 
                     {$this->table} q
                LEFT JOIN 
                    authors a ON author_id = a.id
                LEFT JOIN
                    categories c ON category_id = c.id
                WHERE
                q.category_id = :category_id";
               }

                //Prepared statements
                $stmt = $this->conn->prepare($query);

                //Bind ID
                $stmt->bindParam(':category_id', $this->category_id);

                //Execute query
                $stmt->execute();

                if($stmt)  {

                    return $stmt;
                    
                } else{
                    echo json_encode(
                        array('message' => 'No Quotes Found')
                    );
                    exit();
                }

        }

        //Create Quote
        public function create() {
            //query if author_id exists
            $queryAuthorId = "SELECT quote
                            FROM {$this->table} 
                            WHERE author_id = :author_id";
            
            $stmt = $this->conn->prepare($queryAuthorId);
            $stmt->bindParam(':author_id', $this->author_id);
            if($stmt->execute()){
                    if ($stmt->rowCount() === 0){
                    echo json_encode(
                        array('message' => 'author_id Not Found')
                    );
                    exit();
                }
            }

            //query if category_id exists
            $queryCategoryID = "SELECT quote
                            FROM {$this->table} 
                            WHERE category_id = :category_id";
            
            $stmt = $this->conn->prepare($queryCategoryID);
            $stmt->bindParam(':category_id', $this->category_id);
            if($stmt->execute()){
                    if ($stmt->rowCount() === 0){
                    echo json_encode(
                        array('message' => 'category_id Not Found')
                    );
                    exit();
                }
            }

            //create query
            $query = "INSERT INTO {$this->table} (quote, author_id, category_id)
            VALUES (:quote, :author_id, :category_id)";

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));

            //Bind data from above
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            //execute query
            if ($stmt->execute()) {
                $lastId = $this->conn->lastInsertId();
                return true;
            }
            //print error
            else{           
            printf("Error: %s. \n", $stmt->error);

            return false;
            }
        }

        //Delete Quote
        public function delete() {
            //Create delete query
            $query = "DELETE FROM {$this->table} WHERE id = :id";

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data from above
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
            if($stmt->rowCount() < 1) {
                return false;
            } else {
                return true;
            }
     
        }

        //Update Quote
        public function update() {
            //query if id exists
            $queryId = "SELECT quote
                            FROM {$this->table} 
                            WHERE id = :id";
            
            $stmt = $this->conn->prepare($queryId);
            $stmt->bindParam(':id', $this->id);
            if($stmt->execute()){
                    if ($stmt->rowCount() === 0){
                    echo json_encode(
                        array('message' => 'No Quotes Found')
                    );
                    exit();
                }
            }

            //query if author_id exists
            $queryAuthorId = "SELECT quote
                            FROM {$this->table} 
                            WHERE author_id = :author_id";
            
            $stmt = $this->conn->prepare($queryAuthorId);
            $stmt->bindParam(':author_id', $this->author_id);
            if($stmt->execute()){
                    if ($stmt->rowCount() === 0){
                    echo json_encode(
                        array('message' => 'author_id Not Found')
                    );
                    exit();
                }
            }

            //query if category_id exists
            $queryCategoryID = "SELECT quote
                            FROM {$this->table} 
                            WHERE category_id = :category_id";
            
            $stmt = $this->conn->prepare($queryCategoryID);
            $stmt->bindParam(':category_id', $this->category_id);
            if($stmt->execute()){
                    if ($stmt->rowCount() === 0){
                    echo json_encode(
                        array('message' => 'category_id Not Found')
                    );
                    exit();
                }
            }

            //Update query
            $query = "UPDATE {$this->table} 
            SET quote = :quote
            WHERE id = :id";

            //prepare statement
            $stmt = $this->conn->prepare($query);


            //Bind data from above
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);

            //execute query
            if ($stmt->execute()) {
                return true;
            }
            //print error
            else{           
                echo json_encode(
                    array('message' => 'No Quotes Found')
                );
                exit();
            }
        }
    }


?>
