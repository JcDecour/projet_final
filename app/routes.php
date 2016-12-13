<?php
	
// Routes du front
$front_r = array(
	['GET', '/', 'Default#home', 'front_default_home'],

	// Routes services
	['GET|POST', '/service/add', 'Services#add', 'front_service_add'],
	['GET|POST', '/service/list_services', 'Services#list_services', 'front_list_services'],
	['GET|POST', '/service/delete_service/[i:id]', 'Services#delete_service', 'front_delete_service'],
	['GET|POST', '/service/edit_service/[i:id]', 'Services#edit_service', 'front_edit_service'],


	// Routes Clients
	['GET|POST', '/customer/login', 'Customer#login', 'front_customer_login'],
	['GET|POST', '/customer/logout', 'Customer#logout', 'front_customer_logout'],

	// Les routes ajax
	['GET', '/ajax/refresh_subsector', 'Ajax#refreshSubSector', 'ajax_refreshSubSector'],

);
// Routes du back
$back_r = array(
	['GET', '/', 'Default#home', 'back_default_home'],
);



/**
 * Ajout des préfixes Front / Back devant le nom des controllers
 */
foreach($front_r as $r){
	$r[2] = 'Front\\'.ucfirst(str_replace('Front', '', $r[2]));
	$front_routes[] = $r;
}
foreach($back_r as $r){
	$r[2] = 'Back\\'.ucfirst(str_replace('Back', '', $r[2]));
	$back_routes[] = $r;
}
$w_routes = array_merge($front_routes, $back_routes);
