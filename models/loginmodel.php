<?php

class LoginModel extends Model{

    public function __construct(){
        parent::__construct();
    }

    public function login($username, $password){
        // insertar datos en la BD
       
        try{
            //$query = $this->db->connect()->prepare('SELECT * FROM users WHERE username = :username');
            $query = $this->prepare('SELECT * FROM users WHERE username = :username');
            $query->execute(['username' => $username]);
            
            if($query->rowCount() == 1){
                $item = $query->fetch(PDO::FETCH_ASSOC); 

                $user = new UserModel();
                $user->from($item);

              

                if(password_verify($password, $user->getPassword())){
                   
                    //return ['id' => $item['id'], 'username' => $item['username'], 'role' => $item['role']];
                    return $user;
                    //return $user->getId();
                }else{
                    return NULL;
                }
            }
        }catch(PDOException $e){
            return NULL;
        }
    }

    

}

?>