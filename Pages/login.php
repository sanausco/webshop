<?php
$data = file_get_contents("./json/login.json");

$ex = json_decode($data, true);
$user = $ex["user"];
$password = $ex["password"];

if (isset($_POST["submit"])) {

    if (($_POST["user"] == $user) && ($_POST["password"] == $password)) {
        header("Location:index.php?page=shop");
    } else {
        echo '<script>alert("Wrong login details.")</script>';
    }
}
?>

<body>
    <div id="login_form" >	
        <form  align="center"  action="index.php?page=login" method="POST"  >
            <p>
                <label  class="log-text">Username:</label>
                <input type="text" name="user"></input>
            </p>
            <p>	
                <label class="log-text">Password:</label>
                <input type="password" name="password"></input>
            </p>
            <p>	
                <input type="submit" name="submit" value="Log In"></input>
            </p>
        </form> 
    </div>
</body>