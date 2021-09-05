<?php
/**
 * @author Amin Mahmoudi (MasterkinG)
 * @copyright    Copyright (c) 2019 - 2022, MsaterkinG32 Team, Inc. (https://wootenmane.wootenblatz.com)
 * @link    https://wootenmane.wootenblatz.com
 * @Description : It's not masterking32 framework !
 **/

require_once './application/loader.php';
user::post_handler();
require_once base_path . 'template/' . get_config('template') . '/tpl/main.php';