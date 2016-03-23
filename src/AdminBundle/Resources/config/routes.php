<?php 

Routes::post(['/admin/bundle/login', 'name' => 'admin_bundle_login'], 'AdminBundle:Events:Login@signInAction');

Routes::post(['/admin/bundle/logout', 'name' => 'admin_bundle_logout'], 'AdminBundle:Events:Logout@logoutAction');

Routes::post(['/admin/bundle/passwd', 'name' => 'admin_bundle_passwd'], 'AdminBundle:Events:Logout@logoutAction');