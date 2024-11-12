<?php
    include 'includes/session.php';

    if(isset($_POST['add'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $middlename = $_POST['middlename'];
        $username = $_POST['username'];
        $password = $_POST['password']; // Original password
        $address = $_POST['address'];
        $birthdate = $_POST['birthdate'];
        $contact = $_POST['contact'];
        $gender = $_POST['gender'];
        $position = $_POST['position'];
        $filename = $_FILES['photo']['name'];
        if(!empty($filename)){
            move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);  
        }
        //creating employeeid
        $letters = '';
        $numbers = '';
        foreach (range('A', 'Z') as $char) {
            $letters .= $char;
        }
        for($i = 0; $i < 10; $i++){
            $numbers .= $i;
        }
        $employee_id = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0, 9);
        //

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO employees (employee_id, firstname, middlename, lastname, username, password, address, birthdate, contact_info, gender, position, photo, created_on) VALUES ('$employee_id', '$firstname', '$middlename', '$lastname', '$username', '$hashed_password', '$address', '$birthdate', '$contact', '$gender', '$position', '$filename', NOW())";
        if($conn->query($sql)){
            $_SESSION['success'] = 'Employee added successfully';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }

    }
    else{
        $_SESSION['error'] = 'Fill up add form first';
    }

    header('location: employee.php');
?>
