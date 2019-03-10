<?php
/**
 * <pre>
 * <p>[Summary]</p>
 * Password Manager Class
 * </pre>
 *
 * @author DucToanLe <ductoanle1611@gmail.com>
 */
namespace Manager;

class PasswordManager
{
    protected $username;
    protected $password;

    /**
     * <pre>
     * <p>[Summary]</p>
     * Encrypt data
     * </pre>
     * @param string $password password
     * @return string $passwordEncrypt
     */
    protected function encrypt($password)
    {
        $passwordEncrypt = md5($password);

        return $passwordEncrypt;
    }

    /**
     * <pre>
     * <p>[Summary]</p>
     * Verify Password
     * </pre>
     * @param string $password password
     * @return boolean true: if password correct
     *                         false: if password incorrect
     */
    protected function verifyPassword($password)
    {
        $password = md5($password);
        if ($this->password == $password)
        {
            return true;
        }

        return false;
    }

    /**
     * <pre>
     * <p>[Summary]</p>
     * Validate Password
     * </pre>
     * @param string $password password
     * @return mixed true: if password validate success
     *               arrError: if password validate fail
     */
    public function validatePassword($password)
    {
        $arrError = array();
        //Check password must not contain any whitespace
        $regexSpace = '/\s/';
        if (true == preg_match($regexSpace, $password))
        {
            $arrError[] = "ERROR_SPACE";
        }

        //Check password must be at least 6 characters long
        if (strlen($password) < 6)
        {
            $arrError[] = "ERROR_LENGTH";
        }

        //Check password must contain at least one uppercase, at least one lowercase letter
        $regexUpper = '/[A-Z]/';
        $regexLower = '/[a-z]/';
        if (false == preg_match($regexUpper, $password) || false == preg_match($regexLower, $password))
        {
            $arrError[] = "ERROR_UPPER_LOWER";
        }

        //Check password must contain at least one digit and symbol
        $regexNumber = '/[0-9]/';
        $regexSymbol = '/[-!$@%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/';
        if (false == preg_match($regexNumber, $password) || false == preg_match($regexSymbol, $password))
        {
            $arrError[] = "ERROR_DIGIT_SYMBOL";
        }

        if(count($arrError) > 0)
        {
            return $arrError;
        }

        return true;
    }

    /**
     * <pre>
     * <p>[Summary]</p>
     * Set New Password
     * </pre>
     * @param string $password password
     * @return boolean true: if password validate success
     *                         false: if password validate fail
     */
    public function setNewPassword($password)
    {
        $isValid = $this->validatePassword($password);
        if (true !== $isValid)
        {
            return false;
        }
        else
        {
            $this->password = md5($password);
        }

        return true;
    }
}

