jQuery(document).ready(function ($) {

    //for vairable product code is at end inside ajax

    if(afwsp_php_vars.active_theme == 'woodmart-2' || afwsp_php_vars.active_theme == 'woodmart'){
        $('.wrap-quickview-button div').remove();
    }

    for (var i = 1; i < 5; i++) {
        setTimeout(function() {

            $('.af-wsp-regular-price-html , .af-wsp-regular-price-sale-price-html').each(function(){

                if ($(this).data('product_id')) {
                    var product_id = $(this).data('product_id');

                    if ( $('.af-wsp-regular-price-html'+product_id).length >=2 ) {
                        $('.af-wsp-regular-price-html'+product_id).not(':first').remove();

                    }
                    if ( $('.af-wsp-regular-price-sale-price-html'+product_id).length >=2 ) {
                        $('.af-wsp-regular-price-sale-price-html'+product_id).not(':first').remove();
                    }
                }
            });


        },1000*i);
    }

    //for grouped product
    if($('.woocommerce-grouped-product-list').length  && !$('.single_variation').length){
        var initialPrices = {};
        var classNames = {};

        $('.qty').each(function(index) {
            var productRow = $(this).closest('tr'); // Find the parent row

            var className = '';

            var initialPrice = productRow.find('.woocommerce-grouped-product-list-item__price ins .woocommerce-Price-amount bdi').text();
            
            if(initialPrice == ''){
                className = '.woocommerce-grouped-product-list-item__price .woocommerce-Price-amount bdi';
            }
            else{
                className = '.woocommerce-grouped-product-list-item__price ins .woocommerce-Price-amount bdi';
            }



            initialPrices[index] = productRow.find(className).text();
            
            classNames[index] = productRow.find(className);

            $(this).on('input change', function() {
                var newValue = parseInt($(this).val());

                $('table.tab_bor tbody tr').each(function() {
                    var minQuantity = parseInt($(this).find('td:nth-child(1)').text());
                    var maxQuantity = isNaN(parseInt($(this).find('td:nth-child(2)').text()))?0:parseInt($(this).find('td:nth-child(2)').text());
                    var priceText = $(this).find('td:nth-child(3)').text(); 

                    var replace_price = $(this).find('td:first').data('replace');

                    if ((newValue >= minQuantity && newValue <= maxQuantity) || (newValue >= minQuantity && 0 == maxQuantity)) {
                        var targetPriceElement = productRow.find(className);
                        targetPriceElement.html('<span class="woocommerce-Price-currencySymbol">' + priceText + '</span>');
                        if('yes' == replace_price){
                            $('.woocommerce-grouped-product-list-item__price del').hide();
                        }
                        else{
                            $('.woocommerce-grouped-product-list-item__price del').show();
                        }
                        return false;
                    }
                });

                if (!$('table.tab_bor tbody tr').is(function() {
                    var replace_price = $(this).find('td:first').data('replace');

                    return (newValue >= parseInt($(this).find('td:nth-child(1)').text()) && newValue <= parseInt($(this).find('td:nth-child(2)').text()) || (newValue >= parseInt($(this).find('td:nth-child(1)').text()) && (0 == parseInt($(this).find('td:nth-child(2)').text()) || isNaN(parseInt($(this).find('td:nth-child(2)').text())))));
                })) {
                   $('.af_wsp_list_box').each(function(){
                      $(this).removeClass('af_wsp_selected_list')
                  })
                   $('[name=offer]').each(function(){
                      $(this).prop('checked', false);
                  })
                   $('.af_wsp_inner_small_box').each(function(){
                      $(this).removeClass('af_wsp_selected_card');
                  })
                   $('.woocommerce-grouped-product-list-item__price del').show();
                   classNames[index].text(initialPrices[index]);
               }
           });
        });
        

    }
    //for simple product
    if(!$('.single_variation').length && !$('.product-type-grouped').length){

        var className = '';
        elementorClassName = '';
        blockClassName = '';

        var initialPrice = $('.entry-summary .price ins .woocommerce-Price-amount bdi').text();

        var initialPriceElementor =  $('.elementor-widget-woocommerce-product-price .price ins .woocommerce-Price-amount bdi').text();
        var initialPriceBlock =  $('.wc-block-components-product-price ins .woocommerce-Price-amount bdi').text();
        
        if(initialPrice == '' && initialPriceElementor == '' && initialPriceBlock == ''){
            className = '.entry-summary .price .woocommerce-Price-amount bdi';
            initialPrice = $(className).text();

            elementorClassName = '.elementor-widget-woocommerce-product-price .price .woocommerce-Price-amount bdi';
            initialPriceElementor = $(elementorClassName).text();
            blockClassName = '.wc-block-components-product-price .woocommerce-Price-amount bdi';
            initialPriceBlock = $(blockClassName).text();
        }
        else{
            className = '.entry-summary .price ins .woocommerce-Price-amount bdi';
            elementorClassName = '.elementor-widget-woocommerce-product-price .price ins .woocommerce-Price-amount bdi';
            blockClassName = '.wc-block-components-product-price ins .woocommerce-Price-amount bdi';
        }

        $(document).on('input change','.qty', function(){
            var newValue = parseInt($(this).val());

            $('table.tab_bor tbody tr').each(function() {
                var minQuantity = parseInt($(this).find('td:nth-child(1)').text());
                var maxQuantity = isNaN(parseInt($(this).find('td:nth-child(2)').text()))?0:parseInt($(this).find('td:nth-child(2)').text());
                var priceText = $(this).find('td:nth-child(3)').text(); 
                var replace_price = $(this).find('td:first').data('replace');
                
                if ((newValue >= minQuantity && newValue <= maxQuantity) || (newValue >= minQuantity && 0 == maxQuantity)) {

                    $(className).html('<span class="woocommerce-Price-currencySymbol">' + priceText + '</span>' );
                    $(elementorClassName).html('<span class="woocommerce-Price-currencySymbol">' + priceText + '</span>' );
                    $(blockClassName).html('<span class="woocommerce-Price-currencySymbol">' + priceText + '</span>' );
                    if('yes' == replace_price){
                        $('.entry-summary .price del').hide();
                        $('.b2b-role-based-custom-price').remove();
                        $('.elementor-widget-woocommerce-product-price .price del').hide();
                    }
                    else{

                        if(afwsp_php_vars.af_wps_price_type && afwsp_php_vars.af_wps_price_type == 'sale'){
                            $('.entry-summary .price del').hide();
                            $('.b2b-role-based-custom-price').remove();
                            var delElement = '<del class="b2b-role-based-custom-price"><span class="woocommerce-Price-amount amount">' + initialPrice + '</span></del>';
                            $('.entry-summary .price').prepend(delElement);
                        }else{
                            $('.entry-summary .price del').show();
                        }
                        $('.elementor-widget-woocommerce-product-price .price del').hide();
                        
                    }

                    return false; 
                }
            });

            $('.af_wsp_list_div .af_wsp_list_box').each(function(){

                var min_qty = parseInt($(this).data('min-qty'), 10);
                var max_qty = parseInt($(this).data('max-qty'), 10);
                if(newValue >= min_qty && newValue <= max_qty){
                    $(this).find('input[type="radio"]').prop('checked', true);
                    $(this).addClass('af_wsp_selected_list');
                }else{
                    $(this).find('input[type="radio"]').prop('checked', false);
                    $(this).removeClass('af_wsp_selected_list');
                }
            });

            $('.af_wsp_card_div .af_wsp_inner_small_box').each(function(){
                var min_qty = parseInt($(this).data('min-qty'), 10);
                var max_qty = parseInt($(this).data('max-qty'), 10);
                if(newValue >= min_qty && newValue <= max_qty){
                    $(this).addClass('af_wsp_selected_card');
                }else{
                    $(this).removeClass('af_wsp_selected_card');
                }
            });
            
            if (!$('table.tab_bor tbody tr').is(function() {
                var replace_price = $(this).find('td:first').data('replace');
                return (newValue >= parseInt($(this).find('td:nth-child(1)').text()) && newValue <= parseInt($(this).find('td:nth-child(2)').text()) || (newValue >= parseInt($(this).find('td:nth-child(1)').text()) && (0 == parseInt($(this).find('td:nth-child(2)').text()) || isNaN(parseInt($(this).find('td:nth-child(2)').text())))));
            })) {
                $('.af_wsp_list_box').each(function(){
                  $(this).removeClass('af_wsp_selected_list')
              })
                $('[name=offer]').each(function(){
                  $(this).prop('checked', false);
              })
                $('.af_wsp_inner_small_box').each(function(){
                  $(this).removeClass('af_wsp_selected_card');
              });

            $('.entry-summary .price del').show();
            $(className).text(initialPrice);
            $('.b2b-role-based-custom-price').remove();

            $('.elementor-widget-woocommerce-product-price .price del').show();
            $(elementorClassName).text(initialPriceElementor);
            $('.wc-block-components-product-price del').show();
            $(blockClassName).text(initialPriceBlock);
            }
        });
        $('.qty').trigger('change');
    }



    



    if('' == afwsp_php_vars.addify_wsp_enable_template_heading){
        $('.afwsp_template_header h2').hide()
    }
    else{
        $('.afwsp_template_header h2').show()
        
    }
    
    if('' == afwsp_php_vars.addify_wsp_enable_template_icon){
        $('.afwsp_deals_icon').hide();
    }
    else{
        $('.afwsp_deals_icon').show();
    }
    
    //hiding pricing table on simple product
    if('' == afwsp_php_vars.af_wsp_show_pricing_template){
        $('.responsive').hide();
        $('.af_wsp_list_div').hide();
        $('.af_wsp_card_div').hide();
        $('.af_wsp_template_div').hide();
    }
    else if('yes' == afwsp_php_vars.af_wsp_show_pricing_template){
        if('table' == afwsp_php_vars.addify_wsp_pricing_design_type){
            $('.responsive').show();
            $('.af_wsp_list_div').hide();
            $('.af_wsp_card_div').hide();
        }
        else if('list' == afwsp_php_vars.addify_wsp_pricing_design_type){
            $('.af_wsp_list_div').show();
            $('.responsive').hide();
            $('.af_wsp_card_div').hide();
        }
        else{
            $('.af_wsp_card_div').show();
            $('.responsive').hide();
            $('.af_wsp_list_div').hide();

        }

    }

    



    //hiding pricing table on variable af_wsp_template_divproduct
    $('.variations select').on('change', function() {
        if('' == afwsp_php_vars.af_wsp_show_pricing_template){
            setTimeout(function(){
                $('.responsive').each(function(){
                    $(this).hide();
                })
                $('.af_wsp_list_div').each(function(){
                    $(this).hide();
                })
                $('.af_wsp_card_div').each(function(){
                    $(this).hide();
                })
                $('.af_wsp_template_div').hide();
            },100); 
        }
        else if('yes' == afwsp_php_vars.af_wsp_show_pricing_template){
            setTimeout(function(){
                if('' == afwsp_php_vars.addify_wsp_enable_template_heading){
                    $('.afwsp_template_header h2').hide()
                }
                else{
                    $('.afwsp_template_header h2').show()
                    
                }
                
                if('' == afwsp_php_vars.addify_wsp_enable_template_icon){
                    $('.afwsp_deals_icon').hide();
                }
                else{
                    $('.afwsp_deals_icon').show();
                }

                if('table' == afwsp_php_vars.addify_wsp_pricing_design_type){
                    $('.responsive').show();
                    $('.af_wsp_list_div').hide();
                    $('.af_wsp_card_div').hide();
                }
                else if('list' == afwsp_php_vars.addify_wsp_pricing_design_type){
                    if ($('.af_wsp_radio_div input[type="radio"]').length === 0) {
                        $('.af_wsp_radio_div').append('<input type="radio" name="offer" />');
                    }
                    // $('.af_wsp_radio_div').append('<input type="radio" name="offer" />');

                    $('.af_wsp_list_div').show();
                    $('.responsive').hide();
                    $('.af_wsp_card_div').hide();
                }
                else{
                    $('.af_wsp_card_div').show();
                    $('.responsive').each(function(){
                        $(this).hide();
                    })
                    $('.af_wsp_list_div').hide();

                }
            },100); 



            

        }

        setTimeout(function(){

            var variation_id = $('.variation_id').val();

            if(variation_id != '' && variation_id != '0' ){

                $.ajax({
                    url: afwsp_php_vars.admin_url,
                    type: 'POST',
                    data: {
                        action: 'afwsp_get_variation_price',
                        nonce :  afwsp_php_vars.nonce,
                        variation_id:variation_id
                    },
                    success: function (response) {

                        var original_price = response.data.price;
                        var original_price_formatted = response.data.price;
                        
                        
                        var rows = document.querySelectorAll('.tab_bor tbody tr');

                        rows.forEach(function(row) {

                            var priceStr = row.cells[2].innerText.trim();
                            var currencySymbol = priceStr.match(/[^\d.,]/g).join('').trim();
                            var priceValue = priceStr.replace(currencySymbol, '').trim();
                            var price = parseFloat(priceValue);

                            var decimalPlaces = priceValue.split('.')[1] ? priceValue.split('.')[1].length : 0;

                            var save = (original_price - price) > 0 ? (original_price - price) : 0;

                            var saveFormatted = save.toFixed(decimalPlaces);

                            original_price_formatted = parseFloat(original_price).toFixed(decimalPlaces)
                            
                            var currencyPosition = priceStr.indexOf(currencySymbol);

                            if (currencyPosition === 0) {
                                // row.cells[3].innerText = currencySymbol + ' ' + saveFormatted;
                                original_price_formatted = currencySymbol + ' ' + original_price_formatted;
                            } 
                            else if (currencyPosition === priceStr.length - currencySymbol.length) {
                                // row.cells[3].innerText = saveFormatted + ' ' + currencySymbol;
                                original_price_formatted = original_price_formatted + ' ' + currencySymbol;

                            } 
                            else {
                                if (priceStr.indexOf(currencySymbol + ' ') === 0) {
                                    // row.cells[3].innerText = currencySymbol + ' ' + saveFormatted;
                                    original_price_formatted = currencySymbol + ' ' + original_price_formatted;

                                } else if (priceStr.indexOf(' ' + currencySymbol) === priceStr.length - currencySymbol.length - 1) {
                                    // row.cells[3].innerText = saveFormatted + ' ' + currencySymbol;
                                    original_price_formatted = original_price_formatted + ' ' + currencySymbol;

                                } else {
                                    // row.cells[3].innerText = currencySymbol + ' ' + saveFormatted;
                                    original_price_formatted = currencySymbol + ' ' + original_price_formatted;

                                    
                                }
                            }

                        });

                        //changing price on quantity change for variable price
                        if($('.single_variation').length){
                            var className = '';

                            var initialPrice = $('.single_variation .price ins .woocommerce-Price-amount bdi').text();
                            
                            if(initialPrice == ''){
                                className = '.single_variation .price .woocommerce-Price-amount bdi';
                            }
                            else{
                                className = '.single_variation .price ins .woocommerce-Price-amount bdi';
                            }

                            initialPrice = original_price_formatted;


                            function handleQuantityChange(newValue, className) {
                                $('table.tab_bor tbody tr').each(function() {
                                    var minQuantity = parseInt($(this).find('td:nth-child(1)').text());
                                    var maxQuantity = isNaN(parseInt($(this).find('td:nth-child(2)').text()))?0:parseInt($(this).find('td:nth-child(2)').text());
                                    var priceText = $(this).find('td:nth-child(3)').text(); 
                                    var replace_price = $(this).find('td:first').data('replace');
                                    let vairiation_id = jQuery('.variation_id').val();
                                    let replace_orognal_price = false;

                                    let final_price_text =  jQuery('.af-wsp-regular-price-html'+vairiation_id).html() ;

                                    jQuery('.af-wsp-regular-price-sale-price-html'+vairiation_id).each(function(){

                                        if ($(this).html() && !replace_orognal_price) {
                                            replace_orognal_price = true;
                                            $('.single_variation .woocommerce-variation-price .price').html($(this).html());
                                        }
                                    });

                                    var final_price_text_reqular_price = jQuery('.af-wsp-regular-price-sale-price-html' + vairiation_id);

                                    if ((newValue >= minQuantity && newValue <= maxQuantity) || (newValue >= minQuantity && 0 == maxQuantity)) {
                                        // $(className).html('<span class="woocommerce-Price-currencySymbol">' + priceText + '</span>');

                                        // $('.single_variation .woocommerce-variation-price .price .final_price').html('<del class="af-wsp-strike-regular-price">'+ final_price_text +'</del>'+'<span class="woocommerce-Price-currencySymbol">' + priceText + '</span>');
                                        let final_price = parseFloat(final_price_text.replace(/[^0-9.]/g, ''));
                                        let price = parseFloat(priceText.replace(/[^0-9.]/g, ''));
    
                                        if(price >= final_price ){
                                            replace_price = 'yes';
                                        }
                                        if (afwsp_php_vars.af_wps_price_type && afwsp_php_vars.af_wps_price_type == 'regular' && final_price_text_reqular_price.length) {
                                            var del_price = final_price_text_reqular_price.find('.af-wsp-strike-regular-price').html();
                                            if (del_price) {
                                                final_price_text = del_price;
                                            }
                                        }
                                        final_price_text = '<del class="af-wsp-strike-regular-price">'+ final_price_text +'</del>'+'<span class="woocommerce-Price-currencySymbol">' + priceText + '</span>';

                                        $('.single_variation .woocommerce-variation-price .price').html(final_price_text);
                                        if('yes' == replace_price){
                                            $('.entry-summary .price del, .woocommerce-variation-price .price del').hide();
                                        }
                                        else{

                                            $('.entry-summary .price del, .woocommerce-variation-price .price del').show();
                                        }

                                        return false; 
                                    }else{
                                        final_price_text = jQuery('.af-wsp-regular-price-sale-price-html'+vairiation_id).html();
                                    }

                                    // return false;
                                });

                                if (!$('table.tab_bor tbody tr').is(function() {
                                    return (newValue >= parseInt($(this).find('td:nth-child(1)').text()) && newValue <= parseInt($(this).find('td:nth-child(2)').text()) || (newValue >= parseInt($(this).find('td:nth-child(1)').text()) && (0 == parseInt($(this).find('td:nth-child(2)').text()) || isNaN(parseInt($(this).find('td:nth-child(2)').text())))));
                                })) {
                                   $('.af_wsp_list_box').each(function(){
                                      $(this).removeClass('af_wsp_selected_list')
                                  })
                                   $('[name=offer]').each(function(){
                                      $(this).prop('checked', false);
                                  })
                                   $('.af_wsp_inner_small_box').each(function(){
                                      $(this).removeClass('af_wsp_selected_card');
                                  })

                                   $('.entry-summary .price del').show();
                                   $(className).text(initialPrice);
                               }
                           }

                           $(document).ready(function() {
                            var initialValue = parseInt($('.qty').val()); 
                            handleQuantityChange(initialValue, className); 
                        });

                           $(document).on('input change','.qty', function() { 
                            var newValue = parseInt($(this).val()); 
                            handleQuantityChange(newValue, className); 
                        });
                       }
                   }
               });
}
}, 10);

});




    //card click logic

$(document).on('click' ,'.af_wsp_inner_small_box',function(){
    var min_qty = $(this).data('min-qty');
    if(min_qty>0){
        $('.qty').val(min_qty).trigger('change');
        $('.af_wsp_inner_small_box').each(function(){
            $(this).removeClass('af_wsp_selected_card');
        })
        $(this).addClass('af_wsp_selected_card')
    }
})

setTimeout(function(){
    $('.variations select').trigger('change');
},10);
if ($('.af_wsp_radio_div input[type="radio"]').length === 0) {
    $('.af_wsp_radio_div').append('<input type="radio" name="offer" />');
}

    // $('.af_wsp_radio_div').append('<input type="radio" name="offer" />');

$(document).on('click','.af_wsp_list_box',function(){
    var min_qty = $(this).data('min-qty');

    $(this).find('input[type="radio"]').prop('checked', true);
    $('.qty').val(min_qty).trigger('change');

    $('.af_wsp_list_box').each(function(){
        $(this).removeClass('af_wsp_selected_list');
    })
    $(this).addClass('af_wsp_selected_list');

});

});

