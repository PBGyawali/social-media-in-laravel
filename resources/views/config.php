
<?php
defined('BASE_PATH') or  define("ATTEMPTS_NUMBER", "3");   // attempts - 3
defined('BASE_PATH') or  define("TIME_PERIOD", "60");//10 seconds per try
defined('ALLOWED_IMAGES') or define("ALLOWED_IMAGES", array("jpg", "jpeg", "png", "gif", "bmp"));
defined('ALLOWED_DOC') or   define("ALLOWED_DOC", array("pdf", "doc", "docx", "ppt", "pptx","xls"));
defined('ALLOWED_FILES') or  define("ALLOWED_FILES",array_merge(ALLOWED_IMAGES,ALLOWED_DOC));
defined('SITE_NAME') or  define("SITE_NAME", env('APP_NAME'));

 defined('BASE_URL') or   define("BASE_URL", env('APP_URL').'/');
 defined('ASSETS_URL') or   define("ASSETS_URL", BASE_URL."public/");
 defined('CSS_URL') or   define("CSS_URL", ASSETS_URL."css/");
 defined('JS_URL') or   define("JS_URL", ASSETS_URL."js/");
 defined('PRIVATE_IMAGES_URL') or  define("PRIVATE_IMAGES_URL",ASSETS_URL.'images/');
 defined('IMAGES_URL') or  define("IMAGES_URL",config('app.storage_url').'/public/images/');
 defined('FONTS_URL') or  define("FONTS_URL", ASSETS_URL."font/");
 defined('ADMIN_URL') or  define("ADMIN_URL", BASE_URL."admin/");
 defined('ICONS_URL') or  define("ICONS_URL", PRIVATE_IMAGES_URL."icons/");
 defined('LOGO_URL') or  define("LOGO_URL", PRIVATE_IMAGES_URL."logo/");
 defined('BACKGROUNDS_URL') or  define("BACKGROUNDS_URL", PRIVATE_IMAGES_URL."backgrounds/");
 defined('POST_IMAGES_URL') or  define("POST_IMAGES_URL", IMAGES_URL."post_images/");
 defined('USER_IMAGES_URL') or  define("USER_IMAGES_URL", IMAGES_URL."user_images/");



 defined('BASE_PATH') or  define ("BASE_PATH", resource_path('views/'));
 defined('COMPONENTS') or  define ("COMPONENTS", config('app.component_path'));
 defined('ASSETS_DIR') or  define("ASSETS_DIR", public_path('/'));
 defined('LAYOUTS') or  define("LAYOUTS", BASE_PATH."layouts/");
 defined('FONTS_DIR') or  define("FONTS_DIR", ASSETS_DIR."fonts/");
 defined('ADMIN_DIR') or  define("ADMIN_DIR", BASE_PATH."admin/");
 defined('INCLUDES') or  define("INCLUDES", BASE_PATH."includes/");
 defined('ADMIN_INCLUDES') or  define("ADMIN_INCLUDES", ADMIN_DIR."includes/");
 defined('USER_INCLUDES') or  define("USER_INCLUDES",INCLUDES);
 defined('CSS_DIR') or  define("CSS_DIR", ASSETS_DIR."css/");
 defined('JS_DIR') or  define("JS_DIR", ASSETS_DIR."js/");
 defined('IMAGES_DIR') or  define("IMAGES_DIR", ASSETS_DIR."images/");
 defined('USER_IMAGES_DIR') or  define('USER_IMAGES_DIR', IMAGES_DIR."user_images/");
 defined('POST_IMAGES_DIR') or  define("POST_IMAGES_DIR", IMAGES_DIR."post_images/");
 defined('LOGO_DIR') or  define("LOGO_DIR", IMAGES_DIR."logo/");




?>
