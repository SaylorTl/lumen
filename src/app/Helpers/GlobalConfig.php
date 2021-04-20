<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/18/16
 * Time: 12:18 下午
 */


/**
 * 错误代码
 */
define ('ERROR_NO_ACCESS_TOKEN', 100);
define ('ERROR_NO_ACCESS_TOKEN_DESC', '缺少access_token');

define ('ERROR_WROING_ACCESS_PRIVILEGE', 101);
define ('ERROR_WROING_ACCESS_PRIVILEGE_DESC', 'access_token已过期');

define ('ERROR_NO_ACCESS_PRIVILEGE', 102);
define ('ERROR_NO_ACCESS_PRIVILEGE_DESC', '缺少该接口的权限访问');


/**
 * Redis KEY
 */

define ('REDIS_TOKEN', 'etinout_service_token');
define ('REDIS_PRIVILEGE_LIST', 'etinout_service_privilege_list_');
