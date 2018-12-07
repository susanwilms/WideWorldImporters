<?php
// Initialize the session
//session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "connection.php";

//header
require_once "header.php";

// Define variables and initialize with empty values
$email = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please, vul je gebruikersnaam in!";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please, vul je wachtwoord in!";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT customerid, email, password FROM customers WHERE email = :email";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $customerid = $row["customerid"];
                        $email = $row["email"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
//                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $customerid;
                            $_SESSION["username"] = $email;

                            // Redirect user to welcome page
                            ?><meta http-equiv="refresh" content="0; url=/WideWorldImporters/index.php"><?php
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Dit wachtwoord klopt niet!";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Er bestaat geen account met dit emailadres";
                }
            } else{
                echo "Iets ging mis! Probeer later!";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}


?>
<style>
    .wrapper{
        width: 350px;
        padding: 20px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 1%;
        /*height: 100%;*/
        box-shadow: 3px 4px 6px rgba(0, 0, 0,0.5);
        background-color: #ebebeb;
    }

</style>
    <div class="outer">
        <div class="middle">
            <div class="wrapper">
                <h2>Inloggen</h2>
                <p>Vul je inloggegevens in</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="username" class="form-control <?php if(!empty($username_err)){echo "is-invalid";}?>" value="<?php echo $email; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Wachtwoord</label>
                        <input type="password" name="password" class="form-control <?php if(!empty($password_err)){echo "is-invalid";}?>">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Inloggen">
                    </div>
                    <p>Heb je geen account? <a href="register.php">Account aanmaken</a>.</p>
                </form>
            </div>
        </div>
    </div>
<?php
require_once 'footer.php';
?>