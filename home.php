<?php
        session_start();
        if(isset($_SESSION['admin'])){
            header('location:home.php');
        }
?>
<?php include 'scripts.php' ?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Employee Portal Management System</title>
    <style>
        /* POPPINS FONT */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        *{  
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("images/tuyanlogo.jpg");
    background-size: 32%;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    filter: blur(2px); /* Applies the blur effect only to the image */
    z-index: -1; /* Places the image behind the content */
}
        .wrapper{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: rgba(39, 39, 39, 0.4);
        }
        .nav{
            position: fixed;
            top: 0;
            display: flex;
            justify-content: space-around;
            width: 100%;
            height: 100px;
            line-height: 100px;
            background: linear-gradient(rgba(39,39,39, 0.6), transparent);
            z-index: 100;
        }
        .nav-logo p {
    color: white;
    font-size: 45px;
    font-weight: bold;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Centering */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Adding shadow for depth */
    white-space: nowrap; /* Prevent wrapping */
    overflow: hidden; /* Hide overflow */
}

/* Keyframes for the typing effect */
@keyframes typing {
    from {
        width: 0; /* Start with no text */
    }
    to {
        width: 100%; /* Full text width */
    }
}
        .nav-menu ul{
            display: flex;
        }
        .nav-menu ul li{
            list-style-type: none;
        }
        .nav-menu ul li .link{
            text-decoration: none;
            font-weight: 500;
            color: #fff;
            padding-bottom: 15px;
            margin: 0 25px;
        }
        .link:hover, .active{
            border-bottom: 2px solid #fff;
        }
        .nav-button .btn{
            width: 130px;
            height: 40px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.4);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: .3s ease;
        }
        .btn:hover{
            background: rgba(255, 255, 255, 0.3);
        }
        .nav-menu-btn{
            display: none;
        }
        .form-box{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 512px;
            height: 420px;
            overflow: hidden;
            z-index: 2;
        }
        .login-container{
            position: absolute;
            width: 500px;
            display: flex;
            flex-direction: column;
            transition: .5s ease-in-out;
        }
        .top span{
            color: #fff;
            font-size: small;
            padding: 10px 0;
            display: flex;
            justify-content: center;
        }
        /* Container for date and time */
.date-time-container {
    text-align: center;
    margin-bottom: 20px;
}

/* Styling for date and time */
.date-style {
    color: #ffffff;
    font-size: 24px;
    font-weight: 500;
    margin-bottom: -5px;
}

.time-style {
    color: #ffffff;
    font-size: 28px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: -5px;
}

        .top span a{
            font-weight: 500;
            color: #fff;
            margin-left: 5px;
        }
        header{
            color: #fff;
            font-size: 30px;
            text-align: center;
            padding: 5px 0 5px 0;
        }
        .input-field{
            font-size: 15px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            height: 50px;
            width: 100%;
            padding: 0 10px 0 45px;
            border: none;
            border-radius: 30px;
            outline: none;
            transition: .2s ease;
        }
        .input-field:hover, .input-field:focus{
            background: rgba(255, 255, 255, 0.25);
        }
        ::-webkit-input-placeholder{
            color: #fff;
        }
        .input-box i{
            position: relative;
            top: -35px;
            left: 17px;
            color: #fff;
        }
        .login-box-msg{
            color: white;
            font-size: 20px;
        }
        .submit{
            font-size: 15px;
            font-weight: 500;
            color: black;
            height: 45px;
            width: 100%;
            border: none;
            border-radius: 30px;
            outline: none;
            background: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: .3s ease-in-out;
        }
        .submit:hover{
            background: rgba(255, 255, 255, 0.5);
            box-shadow: 1px 5px 7px 1px rgba(0, 0, 0, 0.2);
        }
        .two-col{
            display: flex;
            justify-content: space-between;
            color: #fff;
            font-size: small;
            margin-top: 10px;
        }
        .two-col .one{
            display: flex;
            gap: 5px;
        }
        .two label a{
            text-decoration: none;
            color: #fff;
        }
        .two label a:hover{
            text-decoration: underline;
        }
        @media only screen and (max-width: 786px){
            .nav-button{
                display: none;
            }
            .nav-menu.responsive{
                top: 100px;
            }
            .nav-menu{
                position: absolute;
                top: -800px;
                display: flex;
                justify-content: center;
                background: rgba(255, 255, 255, 0.2);
                width: 100%;
                height: 90vh;
                backdrop-filter: blur(20px);
                transition: .3s;
            }
            .nav-menu ul{
                flex-direction: column;
                text-align: center;
            }
            .nav-menu-btn{
                display: block;
            }
            .nav-menu-btn i{
                font-size: 25px;
                color: #fff;
                padding: 10px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                cursor: pointer;
                transition: .3s;
            }
            .nav-menu-btn i:hover{
                background: rgba(255, 255, 255, 0.15);
            }
        }
        @media only screen and (max-width: 540px) {
            .wrapper{
                min-height: 100vh;
            }
            .form-box{
                width: 100%;
                height: 500px;
            }
            .login-container{
                width: 100%;
                padding: 0 20px;
            }
        }
        .input-field option {
        color: black;
    }
    .form-group select {
        color: white;
    }
    </style>
</head>
<body>
    <div class="wrapper">
    <nav class="nav">
    <div class="nav-logo">
        <p id="welcome-text"></p> <!-- The JavaScript will fill this -->
    </div>
    <div class="nav-menu" id="navMenu">
    </div>
</nav>

        <!----------------------------- Form box ----------------------------------->    
<div class="form-box">
            <!------------------- login form -------------------------->
            <div class="login-container" id="login">
            <div class="login-box">
            <div class="date-time-container">
  <header id="date" class="date-style"></header>
  <header id="time" class="time-style bold"></header>
</div>

    	<form id="attendance">
          <div class="form-group">
            <select class="input-field" name="status" >
              <option value="in">Time In</option>
              <option value="out">Time Out</option>
            </select>
          </div>
      		<div class="form-group has-feedback">
        		<input type="text" class="input-field input-lg" id="employee" name="employee" placeholder="Employee ID" required autofocus>
      		</div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="submit" name="signin"><i class="fa fa-sign-in"></i> Enter</button>
        		</div>
      		</div>
    	</form>
		<div class="alert alert-success alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-check"></i> <span class="message"></span></span>
    </div>
		<div class="alert alert-danger alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
    </div>
  		
</div>

    <script type="text/javascript">
$(function() {
  var interval = setInterval(function() {
    var momentNow = moment();
    $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));  
    $('#time').html(momentNow.format('hh:mm:ss A'));
  }, 100);

  $('#attendance').submit(function(e){
    e.preventDefault();
    var attendance = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: 'attendance.php',
      data: attendance,
      dataType: 'json',
      success: function(response){
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $('.alert-success').show();
          $('.message').html(response.message);
          $('#employee').val('');
        }
      }
    });
  });
    
});

    const text = "Employee Portal Management System";
    const welcomeTextElement = document.getElementById('welcome-text');
    let index = 0;

    function typeText() {
        // Clear the text each time after it's fully typed
        welcomeTextElement.innerHTML = '';
        index = 0;

        // Function to type the text character by character
        function type() {
            if (index < text.length) {
                welcomeTextElement.innerHTML += text.charAt(index);
                index++;
                setTimeout(type, 80); // Adjust the speed of typing (100ms)
            } else {
                // After typing, wait for a moment and start again
                setTimeout(typeText, 1000); // Wait 2 seconds before starting again
            }
        }
        type(); // Start typing
    }

    // Start the typing effect after the page loads
    window.onload = typeText;

</script>
</body>
</html>