<?php
require '../config.php';
if(isset($_SESSION['id']))
{
    $userId = $_SESSION['id'];
    $userName = $_SESSION['username'];
}
else
{
    header("Location:index.php");
}

$errorArray=[];

function test_input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($db)
{
        if(!isset($_POST['username']) || empty($_POST['username'])){
            $errorArray[]="username";
        }

        if(!isset($_POST['email']) || empty($_POST['email'])){
            $errorArray[]="email";
        }

        if(!isset($_POST['password']) || empty($_POST['password'])){
            $errorArray[]="password";
        }

        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $errorArray[] = "Invalid";
        }
        if(count($errorArray)>0)
        {
            echo "not valid";
            header("Location:../Views/addUser.php?error=".implode(",",$errorArray));
        }
        else
        {
            $username=mysqli_escape_string($db,$_POST['username']);
            $email=mysqli_escape_string($db,$_POST['email']);
            $pass=mysqli_escape_string($db,$_POST['password']);
            $password = md5($pass);
            $result= mysqli_query($db,"insert into users set
                        user_name='$username', email='$email',
                        password='$password';");
                
                        if($result)
                        {
                            header("Location:../Views/DisplayOrders.php");
                        }
                        else
                        {
                            header("Location:../Views/addUser.php?error=wrongEntry");
                        }
                    } 
                    
                }
            
?>