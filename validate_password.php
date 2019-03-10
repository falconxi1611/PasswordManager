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
        /* Style all input fields */
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
        }

        /* Style the submit button */
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
        }

        /* Style the container for inputs */
        .container {
            background-color: #f1f1f1;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 align="center">Password Validation</h3>
    <form action="MainProcess.php" method="post">
        <label for="psw">Password</label>
        <input name="mode" value="checkValidate" hidden>
        <input type="password" id="password" name="password" placeholder="Input your password" required>
        <input type="submit" value="CheckValidate">
        <a href="index.html"><input type="button" value="Back"></a>
        <?php if (isset($_SESSION['message']))
        {
            ?>
            <div class="alert alert-success">
                <strong>Success! </strong> <?php echo $_SESSION['message'];
                session_destroy();
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
    </form>
</div>
</body>
</html>
