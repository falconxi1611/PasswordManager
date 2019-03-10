<?php
/**
 * <pre>
 * <p>[Summary]</p>
 * MainProcess.php
 * </pre>
 *
 * @author DucToanLe <ductoanle1611@gmail.com>
 * Create date: 10-Mar-19 11:28
 */
// Start the session
session_start();
include('PasswordManager.php');
include('User.php');

use Manager\PasswordManager;
use Manager\User;

const MODE_VALIDATE_PASSWORD = 'checkValidate';
const MODE_NEW_USER          = 'newUser';
const MODE_LOGIN             = 'login';
const MODE_CHANGE_PASSWORD   = 'changePassword';


$mode     = (isset($_POST['mode'])) ? $_POST['mode'] : null;
$username = (isset($_POST['username'])) ? $_POST['username'] : null;
$password = (isset($_POST['password'])) ? $_POST['password'] : null;

$passwordManager = new PasswordManager();

switch ($mode)
{
    case MODE_NEW_USER:
        {
            $isValid = $passwordManager->validatePassword($password);
            if (true === $isValid)
            {
                $user   = new User();
                $result = $user->createNewUser($username, $password);
                if (true === $result)
                {
                    $_SESSION['message'] = 'Register Success !';
                }
                else
                {
                    $arrMessage        = convertErrorMessage($result);
                    $_SESSION['error'] = $arrMessage;
                }
            }
            else
            {
                $arrMessage        = convertErrorMessage($isValid);
                $_SESSION['error'] = $arrMessage;
            }
            header('Location: new_user.php');
            break;
        }
    case MODE_VALIDATE_PASSWORD:
        {
            $isValid = $passwordManager->validatePassword($password);
            if (true === $isValid)
            {
                $_SESSION['message'] = 'Password is Valid !';
            }
            else
            {
                $arrMessage        = convertErrorMessage($isValid);
                $_SESSION['error'] = $arrMessage;
            }
            header('Location: validate_password.php');
            break;
        }
    case MODE_LOGIN:
        {
            $location = 'login.php';

            $user     = new User();
            $username = trim($username);
            $password = trim($password);
            $result   = $user->login($username, $password);

            if (true === $result)
            {
                if (isset($_POST['flagChangePw']))
                {
                    $_SESSION['username'] = $username;
                    $location = 'confirm_password.php';
                }
                else
                {
                    $_SESSION['message'] = 'Login Success !';
                }
            }
            else
            {
                $arrMessage        = convertErrorMessage($result);
                $_SESSION['error'] = $arrMessage;
            }

            header('Location: ' . $location);
            break;
        }
    case MODE_CHANGE_PASSWORD:
        {
            $isValid = $passwordManager->validatePassword($password);
            if (true === $isValid)
            {
                $user                = new User();
                $username            = $_SESSION['username'];
                $result              = $user->changePassword($username, $password);
                $_SESSION['message'] = 'Change Password Success !';
            }
            else
            {
                $arrMessage        = convertErrorMessage($isValid);
                $_SESSION['error'] = $arrMessage;
            }
            header('Location: confirm_password.php');

            break;
        }
}

/**
 * <pre>
 * <p>[Summary]</p>
 * Convert Error Message
 * </pre>
 * @param array $arrError arrError
 * @return array $arrMessage
 */
function convertErrorMessage($arrError)
{
    //Define array error message
    $tmpArray   = array(
        'ERROR_SPACE'          => 'The password must not contain any whitespace !',
        'ERROR_LENGTH'         => 'The password must be at least 6 characters long !',
        'ERROR_UPPER_LOWER'    => 'The password must contain at least one uppercase and at least one lowercase letter !',
        'ERROR_DIGIT_SYMBOL'   => 'The password must have at least one digit and symbol !',
        'ERROR_NEW_USER'       => 'Register Fail !',
        'ERROR_USER_EXIST'     => 'User is exist !',
        'ERROR_USER_NOT_EXIST' => 'User NOT exist !',
        'ERROR_LOGIN_FAIL'     => 'Username or password incorrect !',
    );
    $arrMessage = array();
    foreach ($arrError as $key)
    {
        $arrMessage[] = $tmpArray[$key];
    }

    return $arrMessage;
}