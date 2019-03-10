<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        form {
            border: 3px solid #f1f1f1;
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<h2>Change Password</h2>
<strong style="color: red">Please login before change password !</strong>
<form action="MainProcess.php" method="post">

    <div class="container">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>

        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>
        <input name="mode" value="login" hidden>
        <input name="flagChangePw" value="1" hidden>

        <button type="submit">Login</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <a href="index.html">
            <button type="button" class="cancelbtn">Back</button>
        </a>
        <?php if (isset($_SESSION['message']))
        {
            ?>
            <div class="alert alert-success">
                <strong>Success! </strong> <?php echo $_SESSION['message'];
                session_unset('message');
                session_unset('error');
                ?>
            </div>
            <?php
        }
        elseif (isset($_SESSION['error']))
        {
        ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['error'] as $value)
            {

                ?>
                <div class="alert alert-danger">
                    <strong>Error: </strong> <?php echo $value ?>
                </div>
                <?php
            }
            session_destroy();
            }
            ?>
        </div>
    </div>
</form>

</body>
</html>
