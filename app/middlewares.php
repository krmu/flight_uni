<?php
class guard
{
    public function before()
    {
        if (!isset($_SESSION['USER_ID'])) {
            Flight::redirect(Flight::create_full_url('login'));
            exit();
        }
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['token']) != $_SESSION['csrf-token']){
                Flight::halt(403, 'Access denied, invalid token.');
                exit();
            }
        }
    }
    public static function is_admin(bool $is_ajax = false)
    {
        if($is_ajax === true){
            if (!Flight::get_user_data('admin')) {
                Flight::halt(403);
                exit();
            }
        }else if (!Flight::get_user_data('admin')) {
            Flight::redirect(Flight::create_full_url('noaccess'));
            exit();
        }
    }
    public static function is_staff(bool $is_ajax = false)
    {
        
        if($is_ajax === true){
            if (!Flight::get_user_data('admin')) {
                if (!Flight::get_user_data('staff')) {
                    Flight::halt(403);
                    exit();
                }
            }
        }else if (!Flight::get_user_data('admin')) {
            if (!Flight::get_user_data('staff')) {
                Flight::redirect(Flight::create_full_url('noaccess'));
                exit();
            }
        }
    }
    public static function is_active( bool $is_ajax = false)
    {
        if($is_ajax === true){
            if (!Flight::get_user_data('admin')) {
                if (!Flight::get_user_data('is_active')) {
                    Flight::halt(403);
                    exit();
                }
            }
        }else if (!Flight::get_user_data('admin')) {
            if (!Flight::get_user_data('is_active')) {
                Flight::redirect(Flight::create_full_url('noaccess'));
                exit();
            }
        }
    }

}
class api_guard
{
    public function before()
    {
        if (!isset($_SESSION['USER_ID']) || ($_SESSION['csrf-token'] != Flight::request()->getHeader('X-CSRF-TOKEN'))) {
            Flight::json(['error' => 'Unauthorized'], 401);
            exit();
        }
        if($_SERVER['REQUEST_METHOD'] != "POST"){
            Flight::json(['error' => 'Invalid request method'], 403);
            exit();
        }
    }
}
class layout_default
{
    public function after()
    {
        Flight::render('layout_default', []);
    }
}
