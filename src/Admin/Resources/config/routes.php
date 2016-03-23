<?php 

Routes::get('/dash/admin/login', 'Admin\\Events\\Login@loginAction');

Routes::group('/admin', function () {
    Routes::get(['/login', 'name' => 'dash_admin_login'], 'Admin\\Events\\Login@loginAction');

    Routes::match(['GET', 'POST'], ['/passwd', 'name' => 'dash_admin_passwd'], 'Admin\\Events\\Manager@passwdAction');

    Routes::match(['GET', 'POST'], ['/logout', 'name' => 'dash_admin_logout'], 'Admin\\Events\\Logout@signOutAction');

    Routes::post(['/sign/in', 'name' => 'dash_admin_sign_in'], 'Admin\\Events\\Login@signInAction');

    Routes::get(['/index', 'name' => 'dash_admin_board'], 'Admin\\Events\\Dashboard@indexAction');
});