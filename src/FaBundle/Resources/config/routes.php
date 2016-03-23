<?php 

Routes::post(['/admin/bundle/login', 'name' => 'admin_bundle_login'], 'FaBundle:Events:Login@signInAction');

Routes::post(['/admin/bundle/logout', 'name' => 'admin_bundle_logout'], 'FaBundle:Events:Logout@logoutAction');

Routes::post(['/admin/bundle/passwd', 'name' => 'admin_bundle_passwd'], 'FaBundle:Events:Logout@logoutAction');