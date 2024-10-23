<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["phone_number"]) && isset($_POST["password"])) {
        $phonenumber = $_POST["phone_number"];
        $password = $_POST["password"];
        $hostname = "localhost";
        $username = "root";
        $pass = "";
        $dbname = "website";
        $conn = new mysqli($hostname, $username, $pass, $dbname);

        if ($conn->connect_error) {
            die('connection failed:' . $conn->connect_error);
        } else {
            $validate = "SELECT * FROM website_table WHERE phonenumber='$phonenumber' AND password='$password'";
            $result = $conn->query($validate);
            if ($result->num_rows == 1) {
                header("location:homepage.php");
            } else {
                echo("invalid login");
            }
        }
        $conn->close();
        exit;
     } else {
        echo("Phone number or password not set");
   }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>welcome all</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        /* Centering the form container */
        .container {
            width: 400px;
            padding: 16px;
            background-color: red;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }

        /* Styling the h1 header */
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Styling for the form labels */
        label {
            margin: 8px 0 4px;
            display: block;
            font-weight: bold;
        }

        /* Styling for the input fields */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Styling for the buttons */
        button[type="submit"] {
            width: 25%;
            background-color: blue;
            color: white;
            padding: 14px 20px;
            margin: 15px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="reset"] {
            width: 25%;
            background-color: green;
            color: white;
            padding: 14px 20px;
            margin: 15px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cont {
            display: flex;
            justify-content: space-between;
        }
        button[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #45a049;
        }

        /* Styling for the checkbox and links */
        input[type="checkbox"] {
            margin: 16px 0;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Centering and spacing for the entire form */
        form {
            text-align: left;
        }
    </style>
</head>
<body>
<form action="" method="POST">
    <div class="container">
        <center><h1>USER LOGIN FORM</h1></center>
        <label>phone number:</label><br>
        <input type="text" name="phone_number" placeholder="Enter phone number" required><br>
        <label>password:</label><br>
        <input type="password" name="password" placeholder="Enter password" required><br>
        <input type="checkbox" chacked="checked">remember me<br>
        <div class="cont">
            <button type="submit">login</button>
            <input type="reset" class="cancelbtn" value="cancel"><br>
        </div>
        forgot <a href="resetphone_password.php">password?</a><br>
        Don't have account?<a href="signup.php">signup</a>
    </div>
</form>
</body>
</html>
