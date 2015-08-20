<?php

define('WP_MEMORY_LIMIT', '512M');

// Define Environments
$environments = array(
    'development' => 'dev.NEWSITEURL',
    'staging' => 'stage.NEWSITEURL',
    'production' => 'NEWSITEURL',
);

// Get Server name
$server_name = $_SERVER['SERVER_NAME'];
foreach ($environments AS $key => $env) {
    if (strstr($server_name, $env)) {
        define('ENVIRONMENT', $key);
        break;
    }
}
// If no environment is set default to production
if (!defined('ENVIRONMENT')) define('ENVIRONMENT', 'production');

switch (ENVIRONMENT) {
    case 'development':
        define('DB_NAME', 'NEWSITEDATABASENAME_dev');
        define('DB_USER', 'NEWSITEDATABASEUSER_dev');
        define('DB_PASSWORD', 'NEWSITEDEVDBPASS');
        define('DB_HOST', 'localhost');
        define('DB_CHARSET', 'utf8');
        define('WP_SITEURL', 'http://dev.NEWSITEURL');
        define('WP_HOME', 'http://dev.NEWSITEURL');
        define('DB_COLLATE', '');
        define('WPLANG', 'sv_SE');
        // define('COOKIE_DOMAIN', 'dev.NEWSITEURL'); // for cookiless subdomain based CDN
        define('WP_DEBUG_LOG', true);
        define('WP_DEBUG', true);
        break;
    case 'staging':
        define('DB_NAME', 'NEWSITEDATABASENAME_stage');
        define('DB_USER', 'NEWSITEDATABASEUSER_stage');
        define('DB_PASSWORD', 'NEWSITESTAGEDBPASS');
        define('DB_HOST', 'localhost');
        define('DB_CHARSET', 'utf8');
        define('WP_SITEURL', 'http://stage.NEWSITEURL');
        define('WP_HOME', 'http://stage.NEWSITEURL');
        define('DB_COLLATE', '');
        define('WPLANG', 'sv_SE');
        // define('COOKIE_DOMAIN', 'stage.NEWSITEURL'); // for cookiless subdomain based CD
        define('WP_DEBUG_LOG', true);
        define('WP_DEBUG', true);
        break;
    case 'production':
        define('DB_NAME', 'NEWSITEDATABASENAME');
        define('DB_USER', 'NEWSITEDATABASEUSER');
        define('DB_PASSWORD', 'NEWSITEPRODDBPASS');
        define('DB_HOST', 'localhost');
        define('DB_CHARSET', 'utf8');
        define('WP_SITEURL', 'http://NEWSITEURL');
        define('WP_HOME', 'http://NEWSITEURL');
        define('DB_COLLATE', '');
        define('WPLANG', 'sv_SE');
        // define('COOKIE_DOMAIN', 'NEWSITEURL'); // for cookiless subdomain based CD
        define('WP_DEBUG', false);
        define('WP_DEBUG_LOG', false);
        break;
}

$table_prefix = 'NEWSITETABLEPREFIX';


define('ALLOW_UNFILTERED_UPLOADS', true);
define('WP_POST_REVISIONS', 5);

/*MULTISITES SETTINGS*/
define('WP_ALLOW_MULTISITE', NEWSITEALLOWMULTISITE);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'NEWSITEURL');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

define('ADMIN_COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');
define('COOKIEPATH', '');
define('SITECOOKIEPATH', '');

/*SECURITY*/
define('DISALLOW_FILE_EDIT', NEWSITEDISALLOWFILEEDIT);

/*CRON*/
define('DISABLE_WP_CRON', NEWSITEDISABLECRON);


define('AUTH_KEY', 'dECu]i&!`+n~aq$5X.dlI7Jk<@}w#Zz?4Uj`vZ^/{BZF7}0,^ozJTCDGtQj7wTbr');
define('SECURE_AUTH_KEY', 'b4hc~JC-j-8o` XHkX|-Ui{gMi!l,Z.q}k%`d)[=K:K;CXI0u=M;7c=H*3TIm5Qt');
define('LOGGED_IN_KEY', '$cv>AO&$-??o`Q[RnR{4M7ShPBw|N%kE]$}|{,6!@NS+aa:4hbOeNui-7VU`vi>?');
define('NONCE_KEY', '0>n.P$eF_z1us[;6+q+:QkI:Rb)X?yzV}DK4p:A;Q>9-N[q8Y,J3@LSUfTX7mzNy');
define('AUTH_SALT', 'G071Clbxb1>1^|I$Ly/t)Z,[Sxdoz:sgw@xvZ@{gA[2t/So11;]=&=Kw#erU|G%#');
define('SECURE_AUTH_SALT', '9@rw;*8M;/:,MB={*}uj[Mx^bJUV!Q^P:pt|<&#VevqB37]kEvgl7,d6k9NADP&-');
define('LOGGED_IN_SALT', 'y`fcW1c= @Eua=P1B<:9.b@:AMB7|Mf9z=Dg#B.!^Wux5U7)~Kkig`Gty|QRt7G3');
define('NONCE_SALT', 'a9h0LQoqOp+#f<!sy9OYX:g+^Rg7ez*ZYLT: &^|j^2bll,T#/vF(-uU2t4bg7?v');



/** Absoluta sökväg till WordPress-katalogen. */
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

// define( 'SUNRISE', 'on' );

/** Anger WordPress-värden och inkluderade filer. */
require_once(ABSPATH . 'wp-settings.php');