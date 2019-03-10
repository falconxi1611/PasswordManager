<?php
/**
 * <pre>
 * <p>[Summary]</p>
 * User Class
 * </pre>
 *
 * @author DucToanLe <ductoanle1611@gmail.com>
 */

namespace Manager;

class User extends PasswordManager
{
    const FILE_PASSWORD = 'password.txt';

    /**
     * <pre>
     * <p>[Summary]</p>
     * Create New User
     * </pre>
     * @param string $username $username
     * @param string $password password
     * @return boolean true: register success
     *                         false: register fail
     */
    public function createNewUser($username, $password)
    {
        $this->username = $username;
        $this->password = $this->encrypt($password);

        $fileExist = file_exists(self::FILE_PASSWORD);

        $content = $this->username . "|" . $this->password;

        //Check file
        if (true === $fileExist)
        {
            $isEmpty = file_get_contents(self::FILE_PASSWORD);
            if (strlen($isEmpty) != 0)
            {
                $userExist = $this->checkUserExist($username);
                if (true === $userExist)
                {
                    return array('ERROR_USER_EXIST');
                }
                $content = "\n" . $this->username . "|" . $this->password;
            }

        }

        $file   = fopen(self::FILE_PASSWORD, 'a+');
        $result = fwrite($file, $content);
        fclose($file);

        if (false === $result)
        {
            return array('ERROR_NEW_USER');
        }

        return true;
    }

    /**
     * <pre>
     * <p>[Summary]</p>
     * Login
     * </pre>
     * @param string $username $username
     * @param string $password password
     * @return boolean true: register success
     *                         false: register fail
     */
    public function login($username, $password)
    {
        //Check username exist
        $userExist = $this->checkUserExist($username);
        if (false === $userExist)
        {
            return array('ERROR_USER_NOT_EXIST');
        }
        $read = file(self::FILE_PASSWORD);
        foreach ($read as $line)
        {
            $arrUser        = explode('|', $line);
            $arrUser[0]     = trim($arrUser[0]);
            $this->password = trim($arrUser[1]);
            if ($arrUser[0] == $username && true === $this->verifyPassword($password))
            {
                return true;
            }
        }

        return array('ERROR_LOGIN_FAIL');
    }

    /**
     * <pre>
     * <p>[Summary]</p>
     * Change password
     * </pre>
     * @param string $username username
     * @param string $password password
     * @return boolean true: change password success
     *                         false: change password fail
     */
    public function changePassword($username, $password)
    {
        $username   = trim($username);
        $password   = trim($password);
        $read       = file(self::FILE_PASSWORD);
        $arrUserNew = array();
        foreach ($read as $line)
        {
            $arrUser = explode('|', $line);
            if ($arrUser[0] == $username)
            {
                $this->setNewPassword($password);
                $newLine      = $username . '|' . trim($this->password);
                $arrUserNew[] = $newLine;
            }
            else
            {
                $arrUserNew[] = trim($line);
            }
        }

        //Update file
        $file = fopen(self::FILE_PASSWORD, 'w');
        for ($i = 0; $i < count($arrUserNew); $i++)
        {
            if ($i == 0)
            {
                fwrite($file, $arrUserNew[$i]);
            }
            else
            {
                fwrite($file, "\n" . $arrUserNew[$i]);
            }
        }
        fclose($file);

        return true;
    }

    /**
     * <pre>
     * <p>[Summary]</p>
     * Check user exist
     * </pre>
     * @param string $username $username
     * @return boolean true: user exist
     *                         false: user not exist
     */
    private function checkUserExist($username)
    {
        $read = file(self::FILE_PASSWORD);
        foreach ($read as $line)
        {
            $arrUser = explode('|', $line);
            if ($arrUser[0] == $username)
            {
                return true;
            }
        }

        return false;
    }
}

