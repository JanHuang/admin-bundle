<?php 

Routes::group('/dash', function () {
    Routes::get(['/login', 'name' => 'dash_login'], 'Admin\\Events\\Login@loginAction');

    Routes::post(['/sign/in', 'name' => 'dash_sign_in'], 'Admin\\Events\\Login@signInAction');
});