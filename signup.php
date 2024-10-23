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
            $numberchack="SELECT*FROM website_table where phonenumber='$phonenumber'";
            $numberchack = $conn->query( $numberchack);
            if( $numberchack ->num_rows>0){
                echo("User is registered");
                exit();
            }else{
            $register ="INSERT INTO website_table(phonenumber,password) VALUES('$phonenumber', '$password')"; 
            $result = $conn->query($register);
            if ($result===TRUE) {
                header("Location:login.php");
            } else {
                echo("registration failed");
            }
        }
        }
        $conn->close();
        exit;
    } else {
        echo("Phone number or password not set");
 }
}
?>



<DOCTYPE html>
    <html>
<head>
    <title></title>
    <style>
        .container {
            width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2);
        }
        .container label {
            font-weight: bold;
        }
        .cont{
            display: flex;
            justify-content: space-between;
        }
        .container input[type="text"], 
        .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        
        }
        .container button, 
        .container .cancelbtn {
            width: 25%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container button {
            background-color: #4CAF50;
            color: white;
        }
        .container .cancelbtn {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <form action="" method="POSt">
        <div class="container">
            <center><h1>user signup</h1></center>
            <label>Phonenumber:</label><br>
            <input  type="text" name="phone_number" placeholder="Enter phonenumber" required><br>
            <label>Password:</label><br>
            <input  type="text" name="password" placeholder="Enter password" required><br>
            <label>Conform password:</label><br>
            <input  type="password" name="conform_password" placeholder="Enter conform password" required><br>
            <div class="cont">
            <button type="submit">signup</button>
            <input type="reset" class="cancelbtn" value="cancel">
        </div>
    </form>

</body>
    </html>
