<?php 

Routes::group('/dash', function () {
    Routes::get(['/login', 'name' => 'dash_login'], 'Admin\\Events\\Login@loginAction');

    Routes::match(['GET', 'POST'], ['/logout', 'name' => 'dash_logout'], 'Admin\\Events\\Logout@signOutAction');

    Routes::post(['/sign/in', 'name' => 'dash_sign_in'], 'Admin\\Events\\Login@signInAction');

    Routes::get(['/index', 'name' => 'dash_board'], 'Admin\\Events\\Dashboard@indexAction');
});