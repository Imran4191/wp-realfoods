  jQuery( function($) {


	$('#title').prop("required","true");

	
	//enable /disable template heading
	$('#addify_wsp_enable_template_heading').change(enable_template_heading_change);
	function enable_template_heading_change() {
		if ($('#addify_wsp_enable_template_heading').is(":checked")) { 
			$('#addify_wsp_template_heading_text').closest('tr').show();
			$('#addify_wsp_template_heading_text_font_size').closest('tr').show();

		} else {
			$('#addify_wsp_template_heading_text').closest('tr').hide();
			$('#addify_wsp_template_heading_text_font_size').closest('tr').hide();

		}
	}
	

	//enable /disable template icon
	$('#addify_wsp_enable_template_icon').change(enable_template_icon_change);
	function enable_template_icon_change() {
		if ($('#addify_wsp_enable_template_icon').is(":checked")) { 
			$('#addify_wsp_template_icon').closest('tr').show();
		} else {
			$('#addify_wsp_template_icon').closest('tr').hide();
		}
	}

	//enable / disable table border
	$('#addify_wsp_enable_table_border').change(enable_table_border_change);
	function enable_table_border_change() {
		if ($('#addify_wsp_enable_table_border').is(":checked") && $('#addify_wsp_pricing_design_type').val() == 'table' ) { 
			$('#addify_wsp_table_border_color').closest('tr').show();
		} else {
			$('#addify_wsp_table_border_color').closest('tr').hide();
		}
	}

	//enable / disable sale tag for card
	$('#addify_wsp_enable_card_sale_tag').change(enable_card_sale_tag_change);
	function enable_card_sale_tag_change() {
		if ($('#addify_wsp_enable_card_sale_tag').is(":checked") && $('#addify_wsp_pricing_design_type').val() == 'card') { 
			$('#addify_wsp_sale_tag_background_color').closest('tr').show();
			$('#addify_wsp_sale_tag_text_color').closest('tr').show();

		} else {
			$('#addify_wsp_sale_tag_background_color').closest('tr').hide();
			$('#addify_wsp_sale_tag_text_color').closest('tr').hide();
		}
	}
	

	pricing_design_select_change();

	enable_template_heading_change();
	enable_template_icon_change();
	enable_table_border_change();
	enable_card_sale_tag_change();
	

	//pricing type design select change
	$(document).on('change','#addify_wsp_pricing_design_type',pricing_design_select_change);
	function pricing_design_select_change(){
		if($('#addify_wsp_pricing_design_type').val() == 'table'){
			$('.afwsp_table_img').show();
			$('.afwsp_card_img').hide();
			$('.afwsp_list_img').hide();
			$('.afwsp_table_row').closest('tr').show();
			$('.afwsp_list_row').closest('tr').hide();
			$('.afwsp_card_row').closest('tr').hide();



		}
		else if($('#addify_wsp_pricing_design_type').val() == 'list'){
			$('.afwsp_table_img').hide();
			$('.afwsp_card_img').hide();
			$('.afwsp_list_img').show();
			$('.afwsp_table_row').closest('tr').hide();
			$('.afwsp_list_row').closest('tr').show();
			$('.afwsp_card_row').closest('tr').hide();


		}
		else{
			$('.afwsp_table_img').hide();
			$('.afwsp_card_img').show();
			$('.afwsp_list_img').hide();
			$('.afwsp_table_row').closest('tr').hide();
			$('.afwsp_list_row').closest('tr').hide();
			$('.afwsp_card_row').closest('tr').show();



		}
	}


	jQuery(document).on('click', '#remove_image_upload' , function() {
		jQuery('#afwsp_template_icon').val('');
		jQuery('#afwsp_selected_image_display').attr('src', "");
	});

	$(document).on('click','#upload-image-btn',function(){ 
		"use strict";
		var image = wp.media({ 
			title: 'Upload Image',
			multiple: false
		}).open()
		.on('select', function(){
			var uploaded_image = image.state().get('selection').first();
			var image_url = uploaded_image.toJSON().url;
			jQuery('#afwsp_template_icon').val(image_url);
			jQuery('#afwsp_selected_image_display').attr("src", image_url);
		});
	})
	




	
	jQuery('.sel2').select2();
	var ajaxurl = wsp_php_vars.admin_url;
	var nonce   = wsp_php_vars.nonce;

	jQuery(document).ready(function($) {
		$( document ).on('click',".afwsp_export_button",function(e){
			e.preventDefault();
			var offset =0;
			$('.af_wsp_loading_message').css('display','block');
			get_products_for_export(offset);
		})
	})


	function afwsp_convertArrayOfObjectsToCSV(args) {  
		var result, ctr, keys, columnDelimiter, lineDelimiter, data;
		data = args.datas || null;
if (data == null || !data.length) {
	return null;
}
		columnDelimiter = args.columnDelimiter || ',';
		lineDelimiter   = args.lineDelimiter || '\n';
		keys            = Object.keys(data[0]);
		result          = '';
		result         += keys.join(columnDelimiter);
		result         += lineDelimiter;
		data.forEach(function(item) {
			ctr = 0;
			keys.forEach(function(key) {
				if (ctr > 0) {
					result += columnDelimiter;
				}

				result += item[key];
				ctr++;
			});
			result += lineDelimiter;
		});
		return result;
}

	function get_products_for_export(offset){
	 
		jQuery.ajax(
		{
			url:ajaxurl,
			type: 'POST',
			data:{
				action: 'afwsp_export_file_contents_to_csv',
				offset:offset,
				nonce  :nonce,
			},
			success: function (response) 
			{
				var result = response;
				if ( result.status != 'finish' ) {
					var jsonObject = JSON.stringify(result.data);
					if(Object.keys(result.data).length){
						jsonObject     = jsonObject.slice( 1 );
						jsonObject     = jsonObject.slice(0, -1);
						jQuery( '.afwsp-export-output' ).append( jsonObject + ',' );
					}
					get_products_for_export( result.offset );
				} else {
					var string = jQuery( '.afwsp-export-output' ).text();
					string     = string.slice(0, -1);
					string     = '{' + string + '}';

					var data   = {
						'action'   : 'afwsp_string_to_json_for_csv',
						'data'     : string,
						'nonce'    : nonce
					};
					jQuery.post(ajaxurl, data, function( response ) {
							var data, filename, link;
							var csv = afwsp_convertArrayOfObjectsToCSV({
								datas: JSON.parse( response )
							});
						if (csv == null) {
							jQuery('.af_wsp_loading_message').css('display','none');
							jQuery('.afwsp_pricing_export_feedback').html('<p>No pricing rule available for export.</p>').fadeIn(300).fadeOut(3000);
							return;
						}
							filename = 'wholesale-prices-export.csv';
						if (!csv.match(/^data:text\/csv/i)) {
							csv = 'data:text/csv;charset=utf-8,' + csv;
						}

							jQuery('.af_wsp_loading_message').css('display','none');
							jQuery('.afwsp_pricing_export_feedback').html('<p>Prices exported successfully.</p>').fadeIn(300).fadeOut(3000);
							data = encodeURI(csv);
							link = document.createElement('a');
							link.setAttribute('href', data);
							link.setAttribute('download', filename);
							link.click();
					});
				}
			}
		});
}



	jQuery('#wsp_applied_on_categories').select2({
		placeholder: 'Choose Categories'
	});

	jQuery('#wsp_hide_categories').select2({
		placeholder: 'Choose Categories'
	});
	

	jQuery('.sel_pros').select2({

		ajax: {
			url: ajaxurl,
			dataType: 'json',
			type: 'POST',
			delay: 250, 
			data: function (params) {
				return {
					q: params.term, // search query
					action: 'wspsearchProducts', // AJAX action for admin-ajax.php
					nonce: nonce // AJAX nonce for admin-ajax.php
				};
			},
			processResults: function( data ) {
				var options = [];
				if ( data ) {
   
					// data is the array of arrays, and each of them contains ID and the Label of the option
					$.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
						options.push( { id: text[0], text: text[1]  } );
					});
   
				}
				return {
					results: options
				};
			},
			cache: true
		},
		multiple: true,
		placeholder: 'Choose Products',
		minimumInputLength: 3 // the minimum of symbols to input before perform a search
		
	});

jQuery(document).on(
'click',
'.woocommerce_variation',
function(){
jQuery(".sel22").each(function() {
if (!jQuery(this).hasClass('select2-hidden-accessible')) {
jQuery(this).select2();
customer_search();
}
});
}
);


customer_search();
function customer_search(){
	jQuery('.sel22').select2({

		ajax: {
			url: ajaxurl, // AJAX URL is predefined in WordPress admin
			dataType: 'json',
			type: 'POST',
			delay: 250, // delay in ms while typing when to perform a AJAX search
			data: function (params) {
				return {
					q: params.term, // search query
					action: 'wspsearchUsers', // AJAX action for admin-ajax.php
					nonce: nonce // AJAX nonce for admin-ajax.php
				};
			},
			processResults: function( data ) {
				var options = [];
				if ( data ) {
   
					// data is the array of arrays, and each of them contains ID and the Label of the option
					$.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
						options.push( { id: text[0], text: text[1]  } );
					});
   
				}
				return {
					results: options
				};
			},
			cache: true
		},
		multiple: false,
		placeholder: 'Choose Users',
		minimumInputLength: 3 // the minimum of symbols to input before perform a search
		
	});
}
	


	$('.save-variation-changes').prop('disabled', false);

	$('#wsp_enable_hide_pirce').change(function () {
		if (this.checked) { 
			//  ^
			$('#hide_div').fadeIn('fast');
		} else {
			$('#hide_div').fadeOut('fast');
		}
	});

	$('#wsp_enable_hide_pirce_registered').change(function () {
		if (this.checked) { 
			//  ^
			$('#userroles').fadeIn('fast');
		} else {
			$('#userroles').fadeOut('fast');
		}
	});

	$('#wsp_hide_price').change(function () {
		if (this.checked) { 
			//  ^
			$('#hp_price').fadeIn('fast');
		} else {
			$('#hp_price').fadeOut('fast');
		}
	});

	$('#wsp_hide_cart_button').change(function () {
		if (this.checked) { 
			//  ^
			$('.hp_cart').fadeIn('fast');
		} else {
			$('.hp_cart').fadeOut('fast');
		}
	});

	$('#wsp_apply_on_all_products').change(function () {
		if (this.checked) { 
			//  ^
			$('.hide_all_pro').fadeOut('fast');
			$('#wsp_applied_on_products').removeAttr('required');
            $('#wsp_applied_on_categories').removeAttr('required');
		} else {
			af_wsp_product_and_category_on_change();
			$('.hide_all_pro').fadeIn('fast');
		}
	});

	$(document).on('change','#wsp_applied_on_products, #wsp_applied_on_categories ',af_wsp_product_and_category_on_change);


        function af_wsp_product_and_category_on_change(){
          if($('#wsp_applied_on_products').val() && $('#wsp_applied_on_products').val().length == 0 && ($("#wsp_applied_on_categories").val()) && $("#wsp_applied_on_categories").val().length == 0){
            $('#wsp_applied_on_products').attr('required','true');
            $('#wsp_applied_on_categories').attr('required','true');
          }
          else{
            $('#wsp_applied_on_products').removeAttr('required');
            $('#wsp_applied_on_categories').removeAttr('required');
          }
      }


	//On Load

	if ($("#wsp_enable_hide_pirce").is(':checked')) {
		$("#hide_div").show();  // checked
	} else {
		$("#hide_div").hide();
	}

	if ($("#wsp_enable_hide_pirce_registered").is(':checked')) {
		$("#userroles").show();  // checked
	} else {
		$("#userroles").hide();
	}

	if ($("#wsp_hide_price").is(':checked')) {
		$("#hp_price").show();  // checked
	} else {
		$("#hp_price").hide();
	}

	if ($("#wsp_hide_cart_button").is(':checked')) {
		$(".hp_cart").show();  // checked
	} else {
		$(".hp_cart").hide();
	}


	if ($("#wsp_apply_on_all_products").is(':checked')) {
		$(".hide_all_pro").hide();  // checked
		$('#wsp_applied_on_products').removeAttr('required');
        $('#wsp_applied_on_categories').removeAttr('required');

	} else {
		$(".hide_all_pro").show();
		af_wsp_product_and_category_on_change();
	}

} );

  jQuery(function($) {
	$(".child").on("click",function() {
		$parent = $(this).prevAll(".parent");
		if ($(this).is(":checked")) {
			$parent.prop("checked",true);
		} else {
			var len = $(this).parent().find(".child:checked").length;
			$parent.prop("checked",len>0);
		}    
	});
	$(".parent").on("click",function() {
		$(this).parent().find(".child").prop("checked",this.checked);
	});
});



jQuery(document).ready(function($){

	//customer rule (global level check)
	function validateAndSetMaxQtyCustomerRuleLevel() {
        $('input[name^="rcus_base_wsp_price"]').each(function() {
            var row = $(this).closest('tr');
            var minQty = parseInt(row.find('input[name$="[min_qty]"]').val());
            var maxQtyInput = row.find('input[name$="[max_qty]"]');
            var maxQty = maxQtyInput.val();

            if (maxQty != 0 && parseInt(maxQty) <= parseInt(minQty)) {
                maxQtyInput.attr('min', minQty+1);
            } else {
                maxQtyInput.removeAttr('min');
            }
        });
    }

    $('input[name$="[min_qty]"], input[name$="[max_qty]"]').on('change', validateAndSetMaxQtyCustomerRuleLevel);

    validateAndSetMaxQtyCustomerRuleLevel();

	//role rule (global level check)
	function validateAndSetMaxQtyRoleRuleLevel() {
        $('input[name^="rrole_base_wsp_price"]').each(function() {
            var row = $(this).closest('tr');
            var minQty = parseInt(row.find('input[name$="[min_qty]"]').val());
            var maxQtyInput = row.find('input[name$="[max_qty]"]');
            var maxQty = maxQtyInput.val();

            if (maxQty != 0 && parseInt(maxQty) <= parseInt(minQty)) {
                maxQtyInput.attr('min', minQty+1);
            } else {
                maxQtyInput.removeAttr('min');
            }
        });
    }

    $('input[name$="[min_qty]"], input[name$="[max_qty]"]').on('change', 	validateAndSetMaxQtyRoleRuleLevel);

    validateAndSetMaxQtyRoleRuleLevel();



	//Customer rule (product level check)
	function validateAndSetMaxQtyCustomerProductLevel() {
        $('input[name^="cus_base_wsp_price"]').each(function() {
			console.log("480");
            var row = $(this).closest('tr');
            var minQty = parseInt(row.find('input[name$="[min_qty]"]').val());
            var maxQtyInput = row.find('input[name$="[max_qty]"]');
            var maxQty = maxQtyInput.val();

            if (maxQty != 0 && parseInt(maxQty) <= parseInt(minQty)) {
                maxQtyInput.attr('min', minQty+1);
            } else {
                maxQtyInput.removeAttr('min');
            }
        });
    }

    $('input[name$="[min_qty]"], input[name$="[max_qty]"]').on('change', 	validateAndSetMaxQtyCustomerProductLevel);

    validateAndSetMaxQtyCustomerProductLevel();


	//role rule (product level check)
	function validateAndSetMaxQtyRoleProductLevel() {
        $('input[name^="role_base_wsp_prices"]').each(function() {
            var row = $(this).closest('tr');
            var minQty = parseInt(row.find('input[name$="[min_qty]"]').val());
            var maxQtyInput = row.find('input[name$="[max_qty]"]');
            var maxQty = maxQtyInput.val();

            if (maxQty != 0 && parseInt(maxQty) <= parseInt(minQty)) {
                maxQtyInput.attr('min', minQty+1);
            } else {
                maxQtyInput.removeAttr('min');
            }
        });
    }

    $('input[name$="[min_qty]"], input[name$="[max_qty]"]').on('change', 	validateAndSetMaxQtyRoleProductLevel);

    validateAndSetMaxQtyRoleProductLevel();


	//Customer rule (variation level check)

    function validateAndSetMaxQtyCustomerVariationLevel() {
        $('input[name*="cus_base_wsp_price"]').each(function() {
            var row = $(this).closest('tr');
            var minQty = parseInt(row.find('input[name*="[min_qty]"]').val());
            var maxQtyInput = row.find('input[name*="[max_qty]"]');
            var maxQty = parseInt(maxQtyInput.val());



            if (maxQty !== 0 && !isNaN(maxQty) && maxQty <= minQty) {
                maxQtyInput.attr('min', minQty + 1);
            } else {
                maxQtyInput.removeAttr('min');
            }
        });
    }

    $(document).on('change', 'input[name*="[min_qty]"], input[name*="[max_qty]"]', validateAndSetMaxQtyCustomerVariationLevel);

    validateAndSetMaxQtyCustomerVariationLevel();



	//Rule rule (variation level check)

	function validateAndSetMaxQtyRoleVariationLevel() {
		$('input[name*="role_base_wsp_prices"]').each(function() {
			var row = $(this).closest('tr');
			var minQty = parseInt(row.find('input[name*="[min_qty]"]').val());
			var maxQtyInput = row.find('input[name*="[max_qty]"]');
			var maxQty = parseInt(maxQtyInput.val());

			if (maxQty !== 0 && !isNaN(maxQty) && maxQty <= minQty) {
				maxQtyInput.attr('min', minQty + 1);
			} else {
				maxQtyInput.removeAttr('min');
			}
		});
	}

	$(document).on('change', 'input[name*="[min_qty]"], input[name*="[max_qty]"]', validateAndSetMaxQtyRoleVariationLevel);

	validateAndSetMaxQtyRoleVariationLevel();





	
})