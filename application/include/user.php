<?php
/**
 * @author Amin Mahmoudi (MasterkinG)
 * @copyright    Copyright (c) 2019 - 2022, MsaterkinG32 Team, Inc. (https://wootenmane.wootenblatz.com)
 * @link    https://wootenmane.wootenblatz.com
 * @Description : It's not masterking32 framework !
 **/


use Medoo\Medoo;

class user
{

    public static function post_handler()
    {
        if (!empty($_GET['restore']) && !empty($_GET['key'])) {
            self::restorepassword_setnewpw($_GET['restore'], $_GET['key']);
        }

        if (!empty($_POST['submit'])) {
            if (get_config('battlenet_support')) {
                self::bnet_register();
                self::bnet_changepass();
            } else {
                self::normal_register();
                self::normal_changepass();
            }
        }
    }

    /**
     * Battle.net registration
     * @return bool
     */
    public static function bnet_register()
    {
        global $antiXss;
        if (!($_POST['submit'] == 'register' && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['email']) )) {
            return false;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            error_msg('Use valid email.');
            return false;
        }

        if ($_POST['password'] != $_POST['repassword']) {
            error_msg('Passwords is not equal.');
            return false;
        }

        if (!(strlen($_POST['password']) >= 4 && strlen($_POST['password']) <= 16)) {
            error_msg('Password length is not valid.');
            return false;
        }

        $bnet_hashed_pass = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash('sha256', strtoupper(hash('sha256', strtoupper($_POST['email'])) . ':' . strtoupper($_POST['password']))))))));
        $bnet_account_id = -1;
        
        if (self::check_bnet_email_exists(strtoupper($_POST["email"]))) {
            database::$auth->insert('battlenet_accounts', [
                'email' => $antiXss->xss_clean(strtoupper($_POST['email'])),
                'sha_pass_hash' => $antiXss->xss_clean($bnet_hashed_pass)
            ]);
            $bnet_account_id = database::$auth->id();

            // error_msg('Username or Email is exists.');
            // return false;
        }
        else {
            $datas = database::$auth->select('battlenet_accounts', ['id'], ['email' => Medoo::raw('UPPER(:email)', [':email' => $email])]);
            if(!empty($datas[0])) {
                $bnet_account_id = $datas[0]['id'];
            }
        }

        if($bnet_account_id > 0) {
            if($_POST["numberOfAccounts"]) {
                foreach(range(1,$_POST["numberOfAccounts"]) as $accountIndex) {
                    $username = $bnet_account_id . '#' . $accountIndex;
                    $hashed_pass = strtoupper(sha1(strtoupper($username . ':' . $_POST['password'])));
                    database::$auth->insert('account', [
                        'username' => $antiXss->xss_clean(strtoupper($username)),
                        'sha_pass_hash' => $antiXss->xss_clean($hashed_pass),
                        'email' => $antiXss->xss_clean(strtoupper($_POST['email'])),
                        'expansion' => $antiXss->xss_clean(get_config('expansion')),
                        'battlenet_account' => $bnet_account_id
                    ]);
                    $bnet_account_id = database::$auth->id();
                    $username = $bnet_account_id . '#' . $accountIndex;
                    database::$auth->insert('account_access', [
                        'id' => $bnet_account_id,
                        'gmlevel' => 0,
                        'RealmID' => -1   
                    ]);

                }
            }

        }
        success_msg('Your account has been created.');
        return true;
    }

    /**
     * Registration without battle net servers.
     * @return bool
     */
    public static function normal_register()
    {
        global $antiXss;
        if (!($_POST['submit'] == 'register' && !empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['repassword']) && !empty($_POST['email']) )) {
            return false;
        }

        if (!preg_match('/^[0-9A-Z-_]+$/', strtoupper($_POST['username']))) {
            error_msg('Use valid characters for username.');
            return false;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            error_msg('Use valid email.');
            return false;
        }

        if ($_POST['password'] != $_POST['repassword']) {
            error_msg('Passwords is not equal.');
            return false;
        }

        if (!(strlen($_POST['password']) >= 4 && strlen($_POST['password']) <= 16)) {
            error_msg('Password length is not valid.');
            return false;
        }

        if (!(strlen($_POST['username']) >= 2 && strlen($_POST['username']) <= 16)) {
            error_msg('Username length is not valid.');
            return false;
        }

        if (!self::check_email_exists(strtoupper($_POST['email'])) && !self::check_username_exists(strtoupper($_POST['username']))) {
            error_msg('Username or Email is exists.');
            return false;
        }

        $hashed_pass = strtoupper(sha1(strtoupper($_POST['username'] . ':' . $_POST['password'])));
        database::$auth->insert('account', [
            'username' => $antiXss->xss_clean(strtoupper($_POST['username'])),
            'sha_pass_hash' => $antiXss->xss_clean($hashed_pass),
            'email' => $antiXss->xss_clean(strtoupper($_POST['email'])),
            'reg_mail' => $antiXss->xss_clean(strtoupper($_POST['email'])),
            'expansion' => $antiXss->xss_clean(get_config('expansion'))
        ]);

        success_msg('Your account has been created.');
        return true;
    }

    /**
     * Change password for Battle.net Cores.
     * @return bool
     */
    public static function bnet_changepass()
    {
        global $antiXss;
        if (!($_POST['submit'] == 'changepass' && !empty($_POST['password']) && !empty($_POST['old_password']) && !empty($_POST['repassword']) && !empty($_POST['email']) )) {
            return false;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            error_msg('Use valid email.');
            return false;
        }

        if ($_POST['password'] != $_POST['repassword']) {

            error_msg('Passwords is not equal.');
            return false;
        }

        if (!(strlen($_POST['password']) >= 4 && strlen($_POST['password']) <= 16)) {
            error_msg('Password length is not valid.');
            return true;
        }

        $userinfo = self::get_user_by_email(strtoupper($_POST['email']));
        if (empty($userinfo['username'])) {
            error_msg('Email is not valid.');
            return false;
        }

        $Old_hashed_pass = strtoupper(sha1(strtoupper($userinfo['username'] . ':' . $_POST['old_password'])));
        $hashed_pass = strtoupper(sha1(strtoupper($userinfo['username'] . ':' . $_POST['password'])));

        if (strtoupper($userinfo['sha_pass_hash']) != $Old_hashed_pass) {
            error_msg('Old password is not valid.');
            return false;
        }

        database::$auth->update('account', [
            'sha_pass_hash' => $antiXss->xss_clean($hashed_pass),
            'sessionkey' => '',
            'v' => '',
            's' => ''
        ], [
            'id[=]' => $userinfo['id']
        ]);

        $bnet_hashed_pass = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash('sha256', strtoupper(hash('sha256', strtoupper($userinfo['email'])) . ':' . strtoupper($_POST['password']))))))));

        database::$auth->update('battlenet_accounts', [
            'sha_pass_hash' => $antiXss->xss_clean($bnet_hashed_pass)
        ], [
            'id[=]' => $userinfo['battlenet_account']
        ]);

        success_msg('Password has been changed.');
        return true;
    }

    /**
     * Change password for normal servers.
     * @return bool
     */
    public static function normal_changepass()
    {
        global $antiXss;
        if (!($_POST['submit'] == 'changepass' && !empty($_POST['password']) && !empty($_POST['old_password']) && !empty($_POST['repassword']) && !empty($_POST['email']) )) {
            return false;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            error_msg('Use valid email.');
            return false;
        }

        if ($_POST['password'] != $_POST['repassword']) {
            error_msg('Passwords is not equal.');
            return false;
        }

        if (!(strlen($_POST['password']) >= 4 && strlen($_POST['password']) <= 16)) {
            error_msg('Password length is not valid.');
            return false;
        }

        $userinfo = self::get_user_by_email(strtoupper($_POST['email']));
        if (empty($userinfo['username'])) {
            error_msg('Email is not valid.');
            return false;
        }

        $Old_hashed_pass = strtoupper(sha1(strtoupper($userinfo['username'] . ':' . $_POST['old_password'])));
        $hashed_pass = strtoupper(sha1(strtoupper($userinfo['username'] . ':' . $_POST['password'])));
        if (strtoupper($userinfo['sha_pass_hash']) != $Old_hashed_pass) {
            error_msg('Old password is not valid.');
            return false;
        }

        database::$auth->update('account', [
            'sha_pass_hash' => $antiXss->xss_clean($hashed_pass),
            'sessionkey' => '',
            'v' => '',
            's' => ''
        ], [
            'id[=]' => $userinfo['id']
        ]);

        success_msg('Password has been changed.');
        return true;
    }

    /**
     * Change password for normal servers.
     * @return bool
     */
    public static function restorepassword()
    {
        global $antiXss;
        if (!($_POST['submit'] == 'restorepassword' && !empty($_POST['email']) )) {
            return false;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            error_msg('Use valid email.');
            return false;
        }

        $userinfo = self::get_user_by_email(strtoupper($_POST['email']));
        if (empty($userinfo['email'])) {
            error_msg('Email is not valid.');
            return false;
        }

        if (empty($userinfo['restore_key'])) {
            self::add_password_key_to_acctbl();
        }

        $restore_key = strtolower(md5(time() . mt_rand(1000, 9999)) . mt_rand(10000,99999));
        database::$auth->update('account', [
            'restore_key' => $antiXss->xss_clean($restore_key)
        ], [
            'id[=]' => $userinfo['id']
        ]);

        $restorepass_URL = get_config('baseurl') . '/index.php?restore=' . strtolower($userinfo['email']) . '&key=' . $restore_key;
        $message = "For restore you game account open <a href='$restorepass_URL' target='_blank'>this link</a>: <BR>$restorepass_URL";
        send_phpmailer(strtolower($userinfo['email']), 'Restore Account Password', $message);
        success_msg('Check your email, (Check SPAM/Junk too).');
        return true;
    }

    public static function restorepassword_setnewpw($email, $restore_key)
    {
        global $antiXss;
        if (empty($email) || empty($restore_key)) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $userinfo = self::get_user_by_email(strtoupper($email));
        if (empty($userinfo['email'])) {
            return false;
        }

        if ($userinfo['restore_key'] != $restore_key) {
            return false;
        }

        $new_password = generateRandomString(12);

        if (get_config('battlenet_support')) {
            $message = 'Your new account information : <br>Email: ' . strtolower($userinfo['email']) . '<br>Password: ' . $new_password;
            $hashed_pass = strtoupper(sha1(strtoupper($userinfo['username'] . ':' . $new_password)));
            database::$auth->update('account', [
                'sha_pass_hash' => $antiXss->xss_clean($hashed_pass),
                'sessionkey' => '',
                'v' => '',
                's' => '',
                'restore_key' => '1'
            ], [
                'id[=]' => $userinfo['id']
            ]);

            $bnet_hashed_pass = strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash('sha256', strtoupper(hash('sha256', strtoupper($userinfo['email'])) . ':' . strtoupper($new_password))))))));
            database::$auth->update('battlenet_accounts', [
                'sha_pass_hash' => $antiXss->xss_clean($bnet_hashed_pass)
            ], [
                'id[=]' => $userinfo['battlenet_account']
            ]);
        } else {
            $message = 'Your new account information : <br>Username: ' . strtolower($userinfo['username']) . '<br>Password: ' . $new_password;
            $hashed_pass = strtoupper(sha1(strtoupper($userinfo['username'] . ':' . $new_password)));
            database::$auth->update('account', [
                'sha_pass_hash' => $antiXss->xss_clean($hashed_pass),
                'sessionkey' => '',
                'v' => '',
                's' => '',
                'restore_key' => '1'
            ], [
                'id[=]' => $userinfo['id']
            ]);
        }

        send_phpmailer(strtolower($userinfo['email']), 'New Account Password', $message);
        success_msg('Check your email for new password, (Check SPAM/Junk too).');
        return false;
    }

    public static function check_bnet_email_exists($email)
    {
        if (!empty($email)) {
            $datas = database::$auth->select('battlenet_accounts', ['id'], ['email' => Medoo::raw('UPPER(:email)', [':email' => $email])]);
            if (empty($datas[0])) {
                return true;
            }
        }
        return false;
    }

    public static function check_email_exists($email)
    {
        if (!empty($email)) {
            $datas = database::$auth->select('account', ['id'], ['email' => Medoo::raw('UPPER(:email)', [':email' => $email])]);
            if (empty($datas[0])) {
                return true;
            }
        }
        return false;
    }

    public static function get_user_by_email($email)
    {
        if (!empty($email)) {
            $datas = database::$auth->select('account', '*', ['email' => Medoo::raw('UPPER(:email)', [':email' => strtoupper($email)])]);
            if (!empty($datas[0]['username'])) {
                return $datas[0];
            }
        }
        return false;
    }

    /**
     * @param $username
     * @return bool
     */
    public static function check_username_exists($username)
    {
        if (!empty($username)) {
            $datas = database::$auth->select('account', ['id'], ['username' => Medoo::raw('UPPER(:username)', [':username' => $username])]);
            if (empty($datas[0])) {
                return true;
            }
        }
        return false;
    }

    public static function get_online_players($realmID)
    {
        $datas = database::$chars[$realmID]->select('characters', array('name', 'race', 'class', 'gender', 'level'), ['LIMIT' => 49, 'ORDER' => ['level' => 'DESC'], 'online[=]' => 1]);
        if (!empty($datas[0]['name'])) {
            return $datas;
        }
        return false;
    }

    public static function get_online_players_count($realmID)
    {
        $datas = database::$chars[$realmID]->count('characters', ['online[=]' => 1]);
        if (!empty($datas)) {
            return $datas;
        }
        return 0;
    }

    public static function add_password_key_to_acctbl()
    {
        database::$auth->query("ALTER TABLE `account` ADD COLUMN `restore_key` varchar(255) NULL DEFAULT '1';");
        return ture;
    }
}
