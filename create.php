<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $Quantity =$Contact= "";
$name_err = $address_err = $Quantity_err =$Contact_err= "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate Quantity
    $input_Quantity = trim($_POST["Quantity"]);
    if(empty($input_Quantity)){
        $Quantity_err = "Please enter the Quantity amount.";     
    } elseif(!ctype_digit($input_Quantity)){
        $Quantity_err = "Please enter a positive integer value.";
    } else{
        $Quantity = $input_Quantity;
    }
    $input_Contact = trim($_POST["Contact"]);
    if(empty($input_Contact)){
        $Contact_err = "Please enter the Contact number.";     
    } elseif(!ctype_digit($input_Contact)){
        $Contact_err = "Please enter a valid phone number.";
    } else{
        $Contact = $input_Contact;
    }
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($Quantity_err) && empty($Contact_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO useleftover (name, address, Quantity,Contact) VALUES (?, ?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_address, $param_Quantity, $param_Contact);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_Quantity = $Quantity;
            $param_Contact = $Contact;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- ===== Fontawesome CDN Link ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper my-3">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-12">
                    <div class="container border border-3 border-dark rounded-3 p-3">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Quantity in gram</label>
                            <input type="text" name="Quantity" class="form-control <?php echo (!empty($Quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Quantity; ?>">
                            <span class="invalid-feedback"><?php echo $Quantity_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="Contact" class="form-control <?php echo (!empty($Contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Contact; ?>">
                            <span class="invalid-feedback"><?php echo $Contact_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>