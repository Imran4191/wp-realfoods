<?php

defined( 'ABSPATH' ) || exit;

class Bwip_Shipping_Method extends WC_Shipping_Method {

  /**
   * Shipping class
   */
  public function __construct() {

      // These title description are display on the configuration page
      $this->id = 'bwip-shipping-method';
      $this->method_title = esc_html__('Table Rate Shipping', 'bwip-shipping' );
      $this->method_description = esc_html__('Table Rate Shipping', 'bwip-shipping' );

      // Run the initial method
      $this->init();

   }

   /**
    ** Load the settings API
    */
   public function init() {
     // Load the settings API
     $this->init_settings();
     // Add the form fields
     $this->init_form_fields();
     add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
   }

   public function init_form_fields() {
      $form_fields = array(
         'enabled' => array(
            'title'   => esc_html__('Enable/Disable', 'bwip-shipping' ),
            'type'    => 'checkbox',
            'label'   => esc_html__('Enable this shipping method', 'bwip-shipping'  ),
            'default' => 'no'
         ),

         'title' => array(
            'title'       => esc_html__('Method Title', 'bwip-shipping' ),
            'type'        => 'text',
            'description' => esc_html__('Enter the method title', 'bwip-shipping'  ),
            'default'     => esc_html__('', 'bwip-shipping' ),
            'desc_tip'    => true,
         ),

         'description' => array(
            'title'       => esc_html__('Description', 'bwip-shipping' ),
            'type'        => 'textarea',
            'description' => esc_html__('Enter the Description', 'bwip-shipping'  ),
            'default'     => esc_html__('', 'bwip-shipping' ),
            'desc_tip'    => true
         ),

         'table_rate_condition' => array(
            'title'       => esc_html__('Condition', 'bwip-shipping' ),
            'type'        => 'select',
            'description' => esc_html__('Condition for Shipping Price', 'bwip-shipping'  ),
            'default'     => esc_html__('package_weight', 'bwip-shipping' ),
            'desc_tip'    => true,
            'options'     => array(
               'package_weight' => esc_html__('Weight vs. Destination', 'bwip-shipping' ),
               'package_value'  => esc_html__('Order Subtotal vs. Destination', 'bwip-shipping' ),
               'package_qty'    => esc_html__('# of Items vs. Destination', 'bwip-shipping' )
            )
         ),

         'table_rate_cost' => array(
            'title'       => esc_html__('Handling Fee', 'bwip-shipping' ),
            'type'        => 'number',
            'description' => esc_html__('Handling Fee', 'bwip-shipping'  ),
            'default'     => esc_html__('', 'bwip-shipping' ),
            'desc_tip'    => true
         ),

         'table_rate_csv' => array(
            'title'       => esc_html__('Table Rate csv', 'bwip-shipping' ),
            'type'        => 'file',
            'description' => esc_html__(get_site_url().'/wp-content/uploads/tablerate/matrixrates-'.$this->getStoreCode().'.csv'),
            'default'     => esc_html__('', 'bwip-shipping' ),
            'desc_tip'    => false,
         ),

         'restricted_method' => array(
            'title'       => esc_html__('Restricted Method Title', 'bwip-shipping' ),
            'type'        => 'text',
            'description' => esc_html__('Enter the method title', 'bwip-shipping'  ),
            'default'     => esc_html__('', 'bwip-shipping' ),
            'desc_tip'    => true,
         ),
      );
      $this->form_fields = $form_fields;
   }

   public function process_admin_options() {
      parent::process_admin_options();
      if(isset($_FILES['woocommerce_bwip-shipping-method_table_rate_csv']) && $_FILES['woocommerce_bwip-shipping-method_table_rate_csv']['name'] != '') {
         $uploaded_file = $_FILES['woocommerce_bwip-shipping-method_table_rate_csv'];

         $currentOrderResponse = file_get_contents($uploaded_file['tmp_name']);
         $currentCsvLines = explode("\n", $currentOrderResponse);
         //remove the first element from the array
         $currentCsvHead = str_getcsv(array_shift($currentCsvLines));
         if(!file_exists(ABSPATH . 'wp-content/uploads/tablerate/')){
            mkdir(ABSPATH . 'wp-content/uploads/tablerate/',0777,true);
         }

         $file = fopen(ABSPATH . 'wp-content/uploads/tablerate/matrixrates-'.$this->getStoreCode().'.csv','w');

         fputcsv($file, $currentCsvHead);
         global $wpdb;
         $table_name = $wpdb->prefix . 'bwip_table_rate';
         $wpdb->query("TRUNCATE TABLE $table_name");

         foreach ($currentCsvLines as $currentCsvLine) {
            $currentLineInCsv = explode(",", $currentCsvLine);

            if(isset($currentLineInCsv[0]) && isset($currentLineInCsv[2]) && isset($currentLineInCsv[3]) && isset($currentLineInCsv[5]) && isset($currentLineInCsv[6]) && isset($currentLineInCsv[7]) && isset($currentLineInCsv[8])){
               $wpdb->insert($table_name, array(
                  'dest_country_id' => $currentLineInCsv[0],
                  'dest_region' => $currentLineInCsv[1],
                  'dest_city' => $currentLineInCsv[2],
                  'dest_zip' => $currentLineInCsv[3],
                  'dest_zip_to' => $currentLineInCsv[4],
                  'condition_name' => $this->settings['table_rate_condition'],
                  'condition_from_value' => $currentLineInCsv[5],
                  'condition_to_value' => $currentLineInCsv[6],
                  'price' => $currentLineInCsv[7],
                  'cost' => $this->settings['table_rate_cost'],
                  'shipping_method' => str_replace('"', '', $currentLineInCsv[8]),
                  'discounts' => $currentLineInCsv[9]
               ));
            }
            
            fputcsv($file, $currentLineInCsv);
         }
      }
   }

   /**
    ** Calculate Shipping rate
    */
   public function calculate_shipping( $package = array() ) {
      global $wpdb;
      $shippingData = [];
      $postcode = ltrim($package['destination']['postcode'], '0');
      $country = $package['destination']['country'];
      $state = $package['destination']['state'];
      $city = $package['destination']['city'];
      $condition_name = $this->settings['table_rate_condition'];
      $weight = 0;
      foreach ( $package['contents'] as $item_id => $values ) {
         $_product = $values['data'];
         $weight += $_product->get_weight() * $values['quantity'];
      }

      if (!ctype_digit($postcode)) {
         $zipSearchString = " AND '{$postcode}' LIKE dest_zip";
      } else {
         $zipSearchString = " AND {$postcode} >= dest_zip AND {$postcode} <= dest_zip_to";
      }
      $zoneWhere='';
      $bind=[];
      for ($j = 0; $j < 8; $j++) {
         switch ($j) {
            case 0: // country, region, city, postcode
               $zoneWhere =  "dest_country_id = '{$country}' AND dest_region = '{$state}' AND STRCMP(LOWER(dest_city),LOWER('{$city}'))= 0 " . $zipSearchString;
               break;
            case 1: // country, region, no city, postcode
               $zoneWhere =  "dest_country_id = '{$country}' AND dest_region = '{$state}' AND dest_city='*' " . $zipSearchString;
               break;
            case 2: // country, region, city, no postcode
               $zoneWhere = "dest_country_id = '{$country}' AND dest_region = '{$state}' AND STRCMP(LOWER(dest_city),LOWER('{$city}'))= 0 AND dest_zip ='*'";
               break;
            case 3: //country, city, no region, no postcode
               $zoneWhere =  "dest_country_id = '{$country}' AND dest_region = '*' AND STRCMP(LOWER(dest_city),LOWER('{$city}'))= 0 AND dest_zip ='*'";
               break;
            case 4: // country, postcode
               $zoneWhere =  "dest_country_id = '{$country}' AND dest_region = '*' AND dest_city ='*' " . $zipSearchString;
               break;
            case 5: // country, region
               $zoneWhere =  "dest_country_id = '{$country}' AND dest_region = '{$state}'  AND dest_city ='*' AND dest_zip ='*'";
               break;
            case 6: // country
               $zoneWhere =  "dest_country_id = '{$country}' AND dest_region = '*' AND dest_city ='*' AND dest_zip ='*'";
               break;
            case 7: // nothing
               $zoneWhere =  "dest_country_id = '*' AND dest_region = '*' AND dest_city ='*' AND dest_zip ='*'";
               break;
         }

         $query = $wpdb->prepare(
            "SELECT shipping_method, price, cost, discounts FROM {$wpdb->prefix}bwip_table_rate WHERE $zoneWhere AND condition_name = '{$condition_name}' AND condition_from_value < {$weight} AND condition_to_value >= {$weight}"
         );
   
         $results = $wpdb->get_results($query);
   
         if (!empty($results)) {
            foreach ($results as $data) {
               $method = strtolower(str_replace(' ', '-', $data->shipping_method));
               $shippingData[$method] = $data;
            }
            break;
         }
      }
      
      $i = 1;
      foreach ($shippingData as $shippingMethod) {
         $shippingPrice = $shippingMethod->price;
         $shippingDiscount = 0;
         $shippingDiscountTxt = $shippingMethod->discounts;
         $subTotal = WC()->cart->subtotal;
         if($shippingMethod->price > 0 && $shippingDiscountTxt != "") {
            if(is_string($shippingDiscountTxt)) {
               $shippingDiscountArray = explode('-', $shippingDiscountTxt);
               if(is_array($shippingDiscountArray)) {
                  $discPercent = [];
                  foreach($shippingDiscountArray as $disTxt) {
                     if(is_string($disTxt) && $disTxt != '') {
                        $disTxtArray = explode(':', str_replace('"', '', $disTxt));
                        if(isset($disTxtArray[0]) && isset($disTxtArray[1])) {
                           $orderAmount = (float) $disTxtArray[0];
                           $percentage  = (float) $disTxtArray[1];
                           if($orderAmount > 0 && $percentage > 0 && $subTotal >= $orderAmount) {
                              $discPercent[] = $percentage;
                           }
                        }
                     }
                  }
                  if(!empty($discPercent)) {
                     $percentage = max($discPercent); 
                     $shippingDiscount =  round(($shippingPrice * $percentage / 100), 2); 
                  }
               }
            }
         }
         $shippingCost = $shippingPrice + $shippingMethod->cost - $shippingDiscount;
         
         $restricted_shipping_method_title = $this->settings['restricted_method'];
         $user_id = get_current_user_id();
         $restricted_shipping_method_enabled = get_user_meta($user_id, 'restricted_shipping_method_enabled', true);
         if ($restricted_shipping_method_title == $shippingMethod->shipping_method) {
            if ($restricted_shipping_method_enabled != 1) {
               continue;
            } else {
               $this->add_rate( array(
                  'id'     => $this->id.'-'.$i,
                  'label'  => $shippingMethod->shipping_method,
                  'cost'   => $shippingCost
               ));
            }
         } else {
            $this->add_rate( array(
               'id'     => $this->id.'-'.$i,
               'label'  => $shippingMethod->shipping_method,
               'cost'   => $shippingCost
            ));
         }
         $i++;
      }
   }

   //Get current store code
   public function getStoreCode() {
      $store = '';
      if (get_current_blog_id()==1) {
         $store = 'uk';
      } else if (get_current_blog_id()==2) {
         $store = 'nz';
      } else if (get_current_blog_id()==3) {
         $store = 'au';
      } else if (get_current_blog_id()==4) {
         $store = 'eu';
      }
      return $store;
   }
}
