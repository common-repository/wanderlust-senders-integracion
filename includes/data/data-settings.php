<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Array of settings
 */

return array(
	'enabled'          => array(
		'title'           => __( 'Activar Senders', 'woocommerce-shipping-senders' ),
		'type'            => 'checkbox',
		'label'           => __( 'Activar este método de envió', 'woocommerce-shipping-senders' ),
		'default'         => 'no'
	),
	'debug'      => array(
		'title'           => __( 'Modo Depuración', 'woocommerce-shipping-senders' ),
		'label'           => __( 'Activar modo depuración', 'woocommerce-shipping-senders' ),
		'type'            => 'checkbox',
		'default'         => 'no',
		'desc_tip'    => true,
		'description'     => __( 'Activar el modo de depuración para mostrar información de depuración en la compra/pago y envío.', 'woocommerce-shipping-senders' )
	),
	'enviroment'      => array(
		'title'           => __( 'Modo Prueba', 'woocommerce-shipping-senders' ),
		'label'           => __( 'Activar modo prueba', 'woocommerce-shipping-senders' ),
		'type'            => 'checkbox',
		'default'         => 'no',
		'desc_tip'    => true,
		'description'     => __( 'Activar el modo prueba.', 'woocommerce-shipping-senders' )
	),
	'title'            => array(
		'title'           => __( 'Título', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( 'Controla el título que el usuario ve durante el pago.', 'woocommerce-shipping-senders' ),
		'default'         => __( 'Senders', 'woocommerce-shipping-senders' ),
		'desc_tip'        => true
	),
	
 	'shipper_fullname' 	=> array(
		'title'           => __( 'Nombre del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'Juan García', 'meta-box' ),
   ),	
 	'shipper_email' 	=> array(
		'title'           => __( 'Email del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'juan@gmail.space', 'meta-box' ),
   ),		
 	'shipper_phone' 	=> array(
		'title'           => __( 'Teléfono del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( '1155552222', 'meta-box' ),
   ),			
 	'pickup_address_line_1' 	=> array(
		'title'           => __( 'Dirección del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'Av. Rivadavia 4321', 'meta-box' ),
   ),		
 	'pickup_address_between_streets' 	=> array(
		'title'           => __( 'Entre calles del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'Pringles y Muñíz', 'meta-box' ),
   ),			
 	'pickup_address_postal_code' 	=> array(
		'title'           => __( 'Código Postal del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'C1205AAD', 'meta-box' ),
   ),			
 	'pickup_address_neighborhood' 	=> array(
		'title'           => __( 'Barrio del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'Almagro', 'meta-box' ),
   ),		
 	'pickup_time_range' 	=> array(
		'title'           => __( 'Rango horario del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( '13 a 15', 'meta-box' ),
   ),		
 	'pickup_time_range' 	=> array(
		'title'           => __( 'Rango horario del remitente', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( '13 a 15', 'meta-box' ),
   ),		
   'user_id'              => array(
		'title'           => __( 'ID Usuario', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'vlxzhl', 'meta-box' ),
   ),
   'user_key'           => array(
		'title'           => __( 'Key', 'woocommerce-shipping-senders' ),
		'type'            => 'text',
		'description'     => __( '', 'woocommerce-shipping-senders' ),
		'default'         => __( '', 'woocommerce-shipping-senders' ),
    'placeholder' => __( 'cnkd11111', 'meta-box' ),
   ),
);