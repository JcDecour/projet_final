<?php
	
// Routes du front
$front_r = array(

	['GET', '/', 'Default#index', 'front_default_index'],
	// Routes services
	['GET|POST', '/service/add', 'Services#add', 'front_service_add'],
	['GET', '/service/list', 'Services#list_services', 'front_list_services'],
	['GET|POST', '/service/delete/[i:id]', 'Services#delete_service', 'front_delete_service'],
	['GET|POST', '/service/edit/[i:idProject]', 'Services#edit', 'front_edit_service'],
	['GET|POST', '/service/view/[i:id]', 'Services#view_service', 'front_view_service'],

	// Routes Clients
	['GET|POST', '/customer/login', 'Customer#login', 'front_customer_login'],
	['GET|POST', '/customer/logout', 'Customer#logout', 'front_customer_logout'],
	['GET|POST', '/customer/signin', 'Customer#signin', 'front_customer_signin'],
	['GET|POST', '/customer/profil', 'Customer#profil', 'front_customer_profil'],
	['GET', '/customer/help', 'Customer#help', 'front_customer_help'],

	//Routes devis
	['GET|POST', '/devis/add/[i:idProjet]', 'Devis#add', 'front_devis_add'],

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
