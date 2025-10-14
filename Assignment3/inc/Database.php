<?php
require_once './inc/config.php';
class Database{
    private $pdo;
    public $error = null;
    
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    private function profileImage(array $uploadedImg){
        if(empty($uploadedImg['name'])){
            $this->error = "Please upload an image";
            return false;
        }

        $fileName = $uploadedImg['name'];
        $fileTempPath = $uploadedImg['tmp_name'];
        $fileSize = $uploadedImg['size'];
        $fileError = $uploadedImg['error'];

        if($fileError != 0){
        $this->error = "Your file was unable to upload";
        return false;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if(!in_array($fileExt, $allowed)){
        $this-> error = "File extenstion must be jpg, jpeg, png or gif";
        return false;
    }

    $maxSize = 2 * 1024 * 1024;
    if($fileSize > $maxSize){
        $this->error = "File size must be less than 2MB";
        return false;
    }

    $newFileName = uniqid('profile', true) . "." . $fileExt;
    $uploadPath = 'uploads/' . $newFileName;
    if(!move_uploaded_file($fileTempPath, $uploadPath)){
        $this->error = "File upload failed";
        return false;
    }
    return $uploadPath;
    }


    public function validEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    $this->error = "Please enter a valid email address.";
    return false;
}

    public function createUser($name, $username, $email, $bio, array $uploadedImg){
        if (!$this->validEmail($email)) {
        return false;
    }

        $imgFile = $this->profileImage($uploadedImg);
        if($imgFile === false){
            return false;
        }
        try{
            $sql = "INSERT INTO users(name,username, email, bio, profile_img) VALUES (:name, :username, :email, :bio, :profile_img)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':bio', $bio);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':profile_img', $imgFile);
            return $stmt->execute(); 
        }catch (PDOException $e){
            $this->error = "Database Error: " . $e->getMessage();

            if(file_exists($imgFile)){
                unlink($imgFile);
            }
            return false;
        }
    }

    public function read(){
        try{
            $sql = "SELECT * FROM users ORDER BY id DESC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            $this->error = "Database read error: " . $e->getMessage();
            return false;
        }
    }
}

$db = new Database($pdo);
?>