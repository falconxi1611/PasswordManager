<?php
/**
 * <pre>
 * <p>[Summary]</p>
 * Password Manager Class
 * </pre>
 *
 * @author DucToanLe
 */

namespace Manager;


class PasswordManager
{
    public $username;
    public $password;

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
        if ($this->password == md5($password))
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
     * @return boolean true: if password validate success
     *                         false: if password validate fail
     */
    public function validatePassword($password)
    {
        //Check password must not contain any whitespace
        $regexSpace = '/\s/';
        if (true == preg_match($regexSpace, $password))
        {
            return false;
        }

        //Check password must be at least 6 characters long.
        if (strlen($password) != 6)
        {
            return false;
        }

        //Check password must contain at least one uppercase, at least one lowercase letter, at least one digit and symbol.
        $regexCharacter = '/^.*(?=.{7,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/';
        if (false == preg_match($regexCharacter, $password))
        {
            return false;
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
        if(false === $isValid)
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
