<?php
// include ('../config.php');
require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country)
{
    //create a connection variable using the db function in config.php
    $conn = db();

    //check if user with this email already exist in the database
    $sql = " SELECT * FROM `students` where `email`='$email' ";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows >= 1) {
        echo '<script>alert("Email found, please login");
              window.location="../forms/login.html";
              </script>';
    } else {
        $sql = "INSERT INTO `students`(`full_names`,`country`,`email`,`gender`,`password`) VALUES ('$fullnames','$country','$email','$gender','$password')";

        $result = mysqli_query($conn, $sql);

        if ($result) {

            echo '<script>alert("User Successfully registered");
        window.location="../forms/login.html";
        </script>';
        } else {
            echo "failed to Register, try again later";
        }

    }
}

//login users
session_start();
function loginUser($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();

    $sql = " SELECT * FROM `students` where `email`='$email' ";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['email'] == $email and $row['password'] == $password) {

            $_SESSION['fullname'] = $row['full_names'];
            echo '<script>alert("Welcome ' . $_SESSION['fullname'] . ' ");
            window.location="../dashboard.php";
            </script>';

        } else {
            echo '<script>alert("Incorrect Username or Password");
            window.location="../forms/login.html";
            </script>';

        }

    } else {
        echo '<script>alert("User not found, please register");
        window.location="../forms/register.html";
        </script>';

    }


}


// echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
//open connection to the database and check if username exist in the database
//if it does, check if the password is the same with what is given
//if true then set user session for the user and redirect to the dasbboard

function resetPassword($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();
    $sql = " SELECT * FROM `students` where `email`='$email' ";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows >= 1) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];

        $sql = "UPDATE `students` SET `password`='$password' WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script>alert("Password Reset Successful");
            window.location="../forms/login.html";
            </script>';

        } else {
            echo '<script>alert("Technical Error please try again later");
            window.location="../";
            </script>';

        }

    } else {
        echo '<script>alert("User does not exist");
            window.location="../forms/register.html";
            </script>';

    }

    // echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
}

function getusers()
{
    $conn = db();
    $sql = "SELECT * FROM `students` ";
    $result = mysqli_query($conn, $sql);
    echo "<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1>
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            //show data
            echo "<tr style='height: 30px'>" .
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 200px; text-align:center';>" . $data['full_names'] . "</td> 
                <td style='width: 200px; text-align:center';>" . $data['email'] . "</td> 
                <td style='width: 200px; text-align:center';>" . $data['gender'] . "</td> 
                <td style='width: 200px; text-align:center';>" . $data['country'] . "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                "value=" . $data['id'] . ">" .
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>" .
                "</tr>";
        }
        echo "</table></table></center></body></html>";
        echo "<button style='background-color:wheat;'> <a href='../dashboard.php'>Back</a> </button>  ";
        
    }
    //return users from the database
    //loop through the users and display them on a table
}

function deleteaccount($id)
{
    $conn = db();
    //delete user with the given id from the database
    $sql= "DELETE FROM `students` WHERE `id`=$id ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<script>alert("User Deleted Successfully");
        window.location="../forms/login.html";
        </script>';

    } else {
        echo '<script>alert("Fail to delete");
        window.location="../dashboard.php";
        </script>';

    }
}
