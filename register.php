<?php
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

require_once "connection.php";
require_once 'header.php';

// Define variables and initialize with empty values
$email = $customername = $password = $confirm_password = $address = $postcode = $city = $country = $phonenumber = "";
$username_err = $customername_err = $password_err = $confirm_password_err = $address_err = $postcode_err = $city_err = $country_err = $phonenumber_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    #<!-- Validation of the email -->
    if(empty(trim($_POST["username"]))){
        $username_err = "Vul een email in.";
    } else{
        // Prepare a select statement to control if this email in use is.
        $sql = "SELECT customerid FROM customers WHERE email = :email";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(":email", $param_username, PDO::PARAM_STR);
            
            //variable that we will use to make the email control
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement if the statement is not empty it will say that its already taken
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Er bestaat al een account met dit emailadres";
                } else{
                    $email = trim($_POST["username"]); //if its empty than we save it in our email variable.
                }
            } else{
                echo "Sorry! Iets ging verkeerd, probeert later!"; //if there is a error in the conection it wil display this message
            }
        }
         
        // Close statement
        unset($stmt);
    }

    #<!-- Validation of the customername -->
    if(empty(trim($_POST["customername"]))){
        $customername_err = "Vul je naam in!";
    } else{
        $customername = $_POST["customername"]; //We don't need to trim this one because it's allowed to have spaces
    }

    #<!-- Validation of the password -->
    if(empty(trim($_POST["password"]))){
        $password_err = "Vul een wachtwoord in!";
    } elseif(strlen(trim($_POST["password"])) < 6){ //this control of the password more that 6 characters is.
        $password_err = "Je wachtwoord moet tenminste 6 tekens zijn.";
    } else{
        $password = trim($_POST["password"]); //if the password meet the requirements it trims it(delete spaces) and save it.
    }

    #<!-- Validation of the confirm password -->
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Bevestig het wachtwoord.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){  //password and confirm password must be the same
            $confirm_password_err = "Wachtwoord komt niet overeen.";
        }
    }

    #<!-- Validation of the adress -->
    if(empty(trim($_POST["address"]))){
        $address_err = "Vul een adres in!";
    } else{
        $address = $_POST["address"]; //We don't need to trim this one because it's allowed to have spaces
    }

    #<!-- Validation of the adress -->
    if(empty(trim($_POST["postcode"]))){
        $postcode_err = "Vul je postcode in!";
    } else{
        $postcode = trim($_POST["postcode"]);
    }

    #<!-- Validation of the city -->
    if(empty(trim($_POST["city"]))){
        $city_err = "Vul je stad in!";
    } else{
        $city = $_POST["city"]; //We don't need to trim this one because it's allowed to have spaces
    }

    #<!-- Defining the country -->
    $country= "Netherlands"; //This is the only choice for the customer.

    #<!-- Validation of the adress -->
    if(empty(trim($_POST["phonenumber"]))){
        $phonenumber_err = "Vul je telefoonnummer in!";
    } else{
        $phonenumber = $_POST["phonenumber"]; //The format is defined in the form
    }



    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($customername_err) && empty($phonenumber_erro) && empty($country_err) && empty($city_err) && empty($address_err) && empty($postcode_err)){
        

            //prepare the stament to be executed
        if($stmt = $conn->prepare('INSERT INTO customers (CustomerID,CustomerName,BillToCustomerID,CustomerCategoryID,
PrimaryContactPersonID,DeliveryMethodID,DeliveryCityID,PostalCityID,AccountOpenedDate,StandardDiscountPercentage,IsStatementSent,
IsOnCreditHold,PaymentDays,Email,PhoneNumber,FaxNumber,WebsiteURL,Country,City,DeliveryAddressLine1,DeliveryPostalCode,
PostalAddressLine1,PostalPostalCode,LastEditedby,ValidFrom,ValidTo,Password) SELECT MAX(customerID)+1,:name,max(customerID)+1,0,1,1,
38187,38187,now(),0,0,0,7,:email,:phonenumber,"Unknown","Unknown",:country,:city,:address,:postcode,"No PO BOX",:postcode,1,now(),
"9999-12-31 23:59:59",:password FROM customers;')){



            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":name", $param_customername, PDO::PARAM_STR);
            $stmt->bindParam(":phonenumber", $param_phonenumber, PDO::PARAM_STR);
            $stmt->bindParam(":country", $param_country, PDO::PARAM_STR);
            $stmt->bindParam(":city", $param_city, PDO::PARAM_STR);
            $stmt->bindParam(":address", $param_address, PDO::PARAM_STR);
            $stmt->bindParam(":postcode", $param_postcode, PDO::PARAM_STR);


            // Set parameters (It's not recommended to use the variable directly)
            $param_username = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash using the bcrypt algorithm
            $param_customername = $customername;
            $param_phonenumber= $phonenumber;
            $param_country= $country;
            $param_city= $city;
            $param_address= $address;
            $param_postcode= $postcode;



            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
                //echo "gast de stmt werk niet :c";
            } else{
                echo "Ik kon je niet naar de login.php pagina sturen";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($conn);
}


?>
 
<style>
    .wrapper{ width: 350px; padding: 20px; }
</style>

    <div class="wrapper">
        <h2>Account aanmaken</h2>
        <p>Vul dit formulier in om een account aan te maken. Alle velden zijn verplicht!</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Emailadres</label>
                <input type="email" name="username" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($customername_err)) ? 'has-error' : ''; ?>">
                <label>Voornaam achternaam</label>
                <input type="text" name="customername" class="form-control" value="<?php echo $customername; ?>">
                <span class="help-block"><?php echo $customername_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Herhaal wachtwoord</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Adres</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($postcode_err)) ? 'has-error' : ''; ?>">
                <label>Postcode</label>
                <input type="text" name="postcode" class="form-control" value="<?php echo $postcode; ?>">
                <span class="help-block"><?php echo $postcode_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>Stad</label>
                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                <span class="help-block"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group">
                <label>Land</label>
                <span class="input-group-addon" style="max-width: 100%;"><i class="glyphicon glyphicon-list"></i></span>
                <select class="selectpicker form-control">
                    <option>Nederland</option>
                </select>
            </div>
            <div class="form-group <?php echo (!empty($phonenumber_err)) ? 'has-error' : ''; ?>">
                <label>Telefoonnummer</label>
                <input type="tel" name="phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
                <span class="help-block"><?php echo $phonenumber_err; ?></span>
            </div>
            <div></div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Verzenden">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Heb je al een account? <a href="login.php">Inloggen</a>.</p>
        </form>
    </div>    
</body>
</html>