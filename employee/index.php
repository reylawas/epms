<?php
        session_start();
        if(isset($_SESSION['admin'])){
            header('location:home.php');
        }
?>
<?php include 'includes/scripts.php' ?>
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
        .top span a{
            font-weight: 500;
            color: #fff;
            margin-left: 5px;
        }
        header{
            color: white;
            font-size: 40px;
            text-align: center;
            padding: 10px 0 30px 0;
        }
        .input-field{
            font-size: 15px;
            background: rgba(255, 255, 255, 0.25);
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
            color: white;
        }
        .input-box i{
            position: relative;
            top: -35px;
            left: 17px;
            color: #fff;
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
                <div class="top">
                    <header>Login</header>
                </div>
                <form action="login.php" method="POST">
                    <div class="input-box">
                        <div class="form-group has-feedback">
                            <input type="text" class="input-field" name="username" placeholder="Username" required autofocus>
                            <i class="bx bx-user"></i>
                        </div>
                    </div>
                    <div class="input-box">
                        <div class="form-group has-feedback">
                            <input type="password" class="input-field" name="password" placeholder="Password" required>
                            <i class="bx bx-lock-alt"></i>
                        </div>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" name="login" value="Sign In">
                    </div>
                    <div class="two-col">
                    </div>
                </form>
				<?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
            </div>
        </div>
    </div>   

    <script>
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
<?php include 'includes/scripts.php' ?>
<!-- Theme style -->
<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
<style type="text/css">
  		.mt20{
  			margin-top:10px;
  		}
      .bold{
        font-weight: bold;
      }
  	</style>
</body>
</html>