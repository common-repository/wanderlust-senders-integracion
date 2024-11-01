<?php
/**
* SENDERS PHP API Class
* Wanderlust Web Design - 2017
*/

 	add_action('wp_ajax_purchase_order_wanderlust_senders', 'purchase_order_wanderlust_senders', 10);
	add_action('wp_ajax_nopriv_purchase_order_wanderlust_senders', 'purchase_order_wanderlust_senders', 10);

	function purchase_order_wanderlust_senders() {
		global $woocommerce, $wp_session;
		session_start();
    $woocommerce_senders_settings = get_option('woocommerce_senders_settings');
    $enviroment = $woocommerce_senders_settings['enviroment']; 
    if($enviroment == 'yes'){
      $_url_endpoint = 'https://sandbox.senders.com.ar/api/v1/shipments';
    } else {
      $_url_endpoint = 'https://api.senders.com.ar/api/v1/shipments';
    }
    $login = $woocommerce_senders_settings['user_id'] .':' . $woocommerce_senders_settings['user_key']; 

 
    $order_id =  $_POST ['dataid'];
	  $order = wc_get_order( $order_id  );   
		$_query_string = array (
          'shipper_fullname' => $woocommerce_senders_settings['shipper_fullname'], // Nombre del remitente
          'shipper_email' => $woocommerce_senders_settings['shipper_email'], // Email del remitente
          'shipper_phone' => $woocommerce_senders_settings['shipper_phone'], // Teléfono del remitente
          'pickup_address_line_1' => $woocommerce_senders_settings['pickup_address_line_1'], // Dirección del remitente
          'pickup_address_between_streets' => $woocommerce_senders_settings['pickup_address_between_streets'], // Entre calles del remitente
          'pickup_address_postal_code' => $woocommerce_senders_settings['pickup_address_postal_code'], // Código Postal del remitente
          'pickup_address_neighborhood' => $woocommerce_senders_settings['pickup_address_neighborhood'], // Barrio del remitente
          'pickup_time_range' => $woocommerce_senders_settings['pickup_time_range'], // Rango horario del remitente
          'receiver_email' => $order->billing_email, // Email del destinatario
          'receiver_fullname' => $order->shipping_first_name . ' ' . $order->shipping_last_name, // Nombre del destinatario
          'destination_address_line_1' => $order->shipping_address_1. ' ' . $order->shipping_address_2, // Dirección del destinatario
          'destination_address_between_streets' => "", // Entre calles del destinatario
          'destination_address_postal_code' => $order->shipping_postcode, // Código postal del destinatario
          'destination_address_neighborhood' => $order->shipping_city, // Barrio del destinatario
          'destination_time_range' => "" // Rango horario del destinatario
     );
      $_query_string = json_encode($_query_string);
      $ch = curl_init();
      curl_setopt_array($ch,  array(  CURLOPT_RETURNTRANSFER  => TRUE,
                                      CURLOPT_HTTPHEADER      => [
                                                'Content-Type: application/json',
                                                'Authorization: '.$login.'' // Identificación de cliente
                                      ],
                                      CURLOPT_CONNECTTIMEOUT  => 5,
																      CURLOPT_CUSTOMREQUEST   => 'POST',
                                      CURLOPT_POST            => TRUE,
                                      CURLOPT_POSTFIELDS      => $_query_string,
                                      CURLOPT_USERAGENT       => 'Ubuntu Chromium/53.0.2785.143 Chrome/53.0.2785.143 Safari/537.36',
                                      CURLOPT_URL             => $_url_endpoint,
                                    ));
    $xml = curl_exec($ch);

    update_post_meta($order_id, '_senders_info',  $xml);
    update_post_meta($order_id, '_senders_info_cancel',  'clean');

    $nre = json_decode($xml);
    echo '<pre>ID Envio: ';print_r($nre->id);echo'</pre>';
    echo '<pre>Estado: ';print_r($nre->shipment_status_detail);echo'</pre>';
    echo '<pre>Estado Pago: ';print_r($nre->payment_status_detail);echo'</pre>';

    die(); 
	}

 	add_action('wp_ajax_purchase_order_wanderlust_senders_cancel', 'purchase_order_wanderlust_senders_cancel', 10);
	add_action('wp_ajax_nopriv_purchase_order_wanderlust_senders_cancel', 'purchase_order_wanderlust_senders_cancel', 10);

	function purchase_order_wanderlust_senders_cancel() {
		global $woocommerce, $wp_session;
      $woocommerce_senders_settings = get_option('woocommerce_senders_settings');
      $enviroment = $woocommerce_senders_settings['enviroment']; 
      if($enviroment == 'yes'){
        $_url_endpoint = 'https://sandbox.senders.com.ar/api/v1/cancel-shipment';
      } else {
        $_url_endpoint = 'https://api.senders.com.ar/api/v1/cancel-shipment';
      }
      $login = $woocommerce_senders_settings['user_id'] .':' . $woocommerce_senders_settings['user_key']; 
      $sender_id = $_url_endpoint . '/'. $_POST['dataid'];
  
      $ch = curl_init($sender_id);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Ubuntu Chromium/53.0.2785.143 Chrome/53.0.2785.143 Safari/537.36');
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: '.$login.'' // Identificación de cliente
      ]);

      $data = curl_exec($ch);
      $info = curl_getinfo($ch);
      curl_close($ch);
      $nre = json_decode($data);
      update_post_meta($_POST['datapost'], '_senders_info_cancel',  $nre);

      echo '<pre style="position: relative; width: 100%;background: #ff5760;color: white;width: 100%;text-align: center;height: 40px;padding: 0px;line-height: 37px;margin-top: 20px;">';print_r($nre->message);echo'</pre>';   
    die(); 
	}


	add_action('add_meta_boxes', 'woocommerce_senders_box_add_box');

	function woocommerce_senders_box_add_box() {
		add_meta_box( 'woocommerce-senders-box', __( 'Senders Envio', 'woocommerce-senders' ), 'woocommerce_senders_box_create_box_content', 'shop_order', 'side', 'default' );
	}
	function woocommerce_senders_box_create_box_content() {
		global $post;
      $woocommerce_senders_settings = get_option('woocommerce_senders_settings');
      $enviroment = $woocommerce_senders_settings['enviroment']; 
      if($enviroment == 'yes'){
        $_url_endpoint = 'https://sandbox.senders.com.ar/api/v1/shipments';
      } else {
        $_url_endpoint = 'https://api.senders.com.ar/api/v1/shipments';
      }
    
      $login = $woocommerce_senders_settings['user_id'] .':' . $woocommerce_senders_settings['user_key']; 
    
		  $order = wc_get_order( $post->ID );
			$shipping = $order->get_items( 'shipping' );
		
		  $senders_infos = get_post_meta($post->ID, '_senders_info', true);
      $senders_info_cancel = get_post_meta($post->ID, '_senders_info_cancel', true);

      $senders_info = json_decode($senders_infos);

			echo '<div class="senders-single">';
			echo '<strong>Tipo de Envio</strong></br>';
			foreach($shipping as $method){
				echo $method['name'];
			}
			echo '</div>';
		  
			if(!empty($senders_info)){
        $sender_id = $_url_endpoint . '/'. $senders_info->id;
        $ch = curl_init($sender_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Ubuntu Chromium/53.0.2785.143 Chrome/53.0.2785.143 Safari/537.36');
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $senders_info = json_decode($data);
        echo  '<div style="position: relative; width: 100%;font-weight: bold;margin-top: 10px;" >ENVIO REALIZADO</div>';
        echo  '<div style="position: relative; width: 100%;padding: 10px 0px;" >ID Envio: '.$senders_info->id.'</div>';
        echo  '<div style="position: relative; width: 100%;padding: 10px 0px;" >Estado Pago: '.$senders_info->payment_status_detail.'</div>';
 				echo  '<div style="position: relative; width: 100%;padding: 10px 0px;" >Estado: '.$senders_info->shipment_status_detail.'</div>';
        if($senders_info_cancel == 'clean' ){
          echo  '<div id="cancelar-senders" data-id="'.$senders_info->id.'" data-post="'.$post->ID.'" style="cursor: pointer;position: relative; width: 100%;background: #ff5760;color: white;width: 100%;text-align: center;height: 40px;padding: 0px;line-height: 37px;margin-top: 20px;" >CANCELAR ENVIO</div>';
        }

			}		 
      if (empty($senders_info)){
        if($senders_info_cancel !='clean'){
          echo '<div id="generar-senders" class="button" data-id="'. $post->ID .'">Generar Envio</div>';
        }
      }  
     
		
		 ?>

			<style type="text/css">
				#generar-senders {
					background: #ff5760;
					color: white;
					width: 100%;
					text-align: center;
					height: 40px;
					padding: 0px;
					line-height: 37px;
					margin-top: 20px;
				}
			</style>

 
			<div class="senders-single-label"> </div>	
			<script type="text/javascript">
        jQuery('body').on('click', '#generar-senders',function(e){ 
          var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
          e.preventDefault();
          var dataid = jQuery(this).data("id");
          jQuery(this).hide();
          jQuery.ajax({
            type: 'POST',
            cache: false,
            url: ajaxurl,
            data: {action: 'purchase_order_wanderlust_senders',dataid: dataid,},
            success: function(data, textStatus, XMLHttpRequest){ 
              jQuery(".senders-single-label").fadeIn(400);
              jQuery(".senders-single-label").html('');
              jQuery(".senders-single-label").append(data);
            },
            error: function(MLHttpRequest, textStatus, errorThrown){ }
          });
        });	
        
        jQuery('body').on('click', '#cancelar-senders',function(e){ 
          var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
          e.preventDefault();
          var dataid = jQuery(this).data("id");
          var datapost = jQuery(this).data("post");
          jQuery(this).hide();
          jQuery.ajax({
            type: 'POST',
            cache: false,
            url: ajaxurl,
            data: {action: 'purchase_order_wanderlust_senders_cancel',dataid: dataid,datapost:datapost,},
            success: function(data, textStatus, XMLHttpRequest){ 
              jQuery(".senders-single-label").fadeIn(400);
              jQuery(".senders-single-label").html('');
              jQuery(".senders-single-label").append(data);
            },
            error: function(MLHttpRequest, textStatus, errorThrown){ }
          });
        });	        
        
			</script>
		<?php  
	}