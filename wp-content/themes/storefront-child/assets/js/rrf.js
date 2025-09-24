(function ($) {
    $(document).ready(function () {
        $(window).on("scroll", function () {
            var scrolled_val = $(document).scrollTop().valueOf();
            if (scrolled_val > 85) {
                if (!$("body").hasClass("scrolled")) {
                    $("body").addClass("scrolled");
                }
            } else {
                $("body").removeClass("scrolled");
            }
        });
        var myInterval = setInterval(function () {
            if (
                $(".prices-tier.items").length &&
                !$.trim(
                    $(".prices-tier.items .item:last-child .extratext").html()
                )
            ) {
                $("<span>   or more<span>").appendTo(
                    ".prices-tier.items .item:last-child .extratext"
                );
                clearInterval(myInterval);
                $(".cart-item-tooltip").removeClass("hide");
            }
        }, 1000);
        $(".header-burger").on("click", function (evt) {
            evt.preventDefault();
            $(this).toggleClass("isopen");
            $("#site-navigation").toggleClass("nav-open");
            $("#slide-login").removeClass("login-open");
            if (
                $("#site-navigation .menu-item-has-children").hasClass(
                    "open-submenu"
                )
            ) {
                $("#site-navigation .menu-item-has-children").toggleClass(
                    "open-submenu"
                );
                $(".sub-menu").animate(
                    {
                        maxHeight: "0",
                    },
                    300
                );
            }
        });

        $(".rosita-login").on("click", function (evt) {
            evt.preventDefault();
            $("#slide-login").toggleClass("login-open");
            $(".header-burger").removeClass("isopen");
            $("#site-navigation").removeClass("nav-open");
            $("#site-navigation .menu-item-has-children").removeClass(
                "open-submenu"
            );
            $(".sub-menu").animate(
                {
                    maxHeight: "0",
                },
                300
            );
        });

        $(document).mouseup(function (e) {
            var rositaLogin = $(".rosita-login"),
                loginBlock = $("#slide-login"),
                navBlock = $("#site-navigation"),
                burgerBlock = $(".header-burger");
            if (
                !rositaLogin.is(e.target) &&
                rositaLogin.has(e.target).length === 0 &&
                !loginBlock.is(e.target) &&
                loginBlock.has(e.target).length === 0 &&
                !navBlock.is(e.target) &&
                navBlock.has(e.target).length === 0 &&
                !burgerBlock.is(e.target) &&
                burgerBlock.has(e.target).length === 0
            ) {
                if ($(".header-burger").hasClass("isopen")) {
                    $(".header-burger").removeClass("isopen");
                    $("#site-navigation").removeClass("nav-open");
                    $("#site-navigation .menu-item-has-children").removeClass(
                        "open-submenu"
                    );
                    $(".sub-menu").animate(
                        {
                            maxHeight: "0",
                        },
                        300
                    );
                }
                if ($("#slide-login").hasClass("login-open")) {
                    $("#slide-login").removeClass("login-open");
                }
            }
        });

        $("#site-navigation .menu-item-has-children").on(
            "click",
            function (evt) {
                if ($(evt.target).parent().hasClass("open-submenu")) {
                    $(".sub-menu").animate(
                        {
                            maxHeight: "0",
                        },
                        300
                    );
                    setTimeout(function () {
                        $(
                            "#site-navigation .menu-item-has-children"
                        ).removeClass("open-submenu");
                    }, 300);
                } else {
                    $(this).addClass("open-submenu");
                    $(".sub-menu").animate(
                        {
                            maxHeight: "500",
                        },
                        300
                    );
                }
            }
        );

        $(".login-username #email").keyup(function () {
            if ($(this).val()) {
                $(".login-username label").hide();
            } else {
                $(".login-username label").show();
            }
        });
        $(".login-password #pass-slide").keyup(function () {
            if ($(this).val()) {
                $(".login-password label").hide();
            } else {
                $(".login-password label").show();
            }
        });

        $(".rosita-search").on("click", function (evt) {
            evt.preventDefault();
            if ($(this).hasClass("isopen")) {
                $(this).removeClass("isopen");
                $(".header-search-container").animate(
                    {
                        maxHeight: "0",
                    },
                    300
                );
            } else {
                $(this).addClass("isopen");
                $(".header-search-container").animate(
                    {
                        maxHeight: "300px",
                    },
                    300
                );
            }
        });

        $("#toggle-password").on("click", function (evt) {
            evt.preventDefault();
            if ($(this).hasClass("eye-open")) {
                $(this).removeClass("eye-open");
                $(this).addClass("eye-close");
                $(".login-password input").prop("type", "text");
            } else {
                $(this).removeClass("eye-close");
                $(this).addClass("eye-open");
                $(".login-password input").prop("type", "password");
            }
        });

        var fromTop = $(window).width() > 600 ? 85 : 56;
        $(".sticky_sidebar").stickySidebar({
            topSpacing: fromTop + 47,
            containerSelector: ".inner-wrapper-sticky",
            resizeSensor: true,
            minWidth: 767,
            bottomSpacing: 100,
        });

        $(".block-collapsible-nav").on("click", function (evt) {
            evt.preventDefault();
            $(
                ".block-collapsible-nav-title",
                ".woocommerce-MyAccount-navigation"
            ).toggleClass("active");
        });

        $(window).on("load", function () {
            $("#customer-login .um-col-1 input").prop("required", true);
            $(".validate-required input,.validate-required select").addClass(
                "required-field"
            );
        });

        $(".woocommerce-MyAccount-navigation").stickySidebar({
            topSpacing: 66,
            containerSelector: "",
            resizeSensor: true,
            minWidth: 767,
            bottomSpacing: 0,
        });

        $(".block-collapsible-nav").on("click", function (evt) {
            evt.preventDefault();
            $(
                ".block-collapsible-nav-title, .woocommerce-MyAccount-navigation"
            ).toggleClass("active");
        });
        $(
            '.contact-dropdown .wpforms-field-large option[value="Please Select"]'
        ).val("");
        $(".wpforms-validate.wpforms-form input").each(function (index) {
            $(this).focusin(function () {
                $(this).parent().find("label").css("display", "none");
            });
            $(this).focusout(function () {
                if (!$(this).val()) {
                    $(this).parent().find("label").css("display", "block");
                }
            });
        });
        $(".wpforms-validate.wpforms-form textarea").focusin(function () {
            $(this).parent().find("label").css("display", "none");
        });
        $(".wpforms-validate.wpforms-form textarea").focusout(function () {
            if (!$(this).val()) {
                $(this).parent().find("label").css("display", "block");
            }
        });

        // BWIPIT-2844 product tab
        $('a[data-toggle="tab"]').on("click", function (e) {
            e.preventDefault();
            $('a[data-toggle="tab"]').parent().removeClass("active");
            $(this).parent().addClass("active");

            $("#faq_section_info .tab-pane").removeClass("active in");
            var targetHref = $(this).attr("href");
            $(targetHref).addClass("active in");
        });

        $("form.woocommerce-cart-form").on("change", "input.qty", function () {
            $('button[name="update_cart"]').addClass("qty-updating");
        });

        $("#block-discount .title").click(function () {
            $("#block-discount").toggleClass("active");
            $(this).attr("aria-expanded", function (index, attr) {
                return attr == "true" ? "false" : "true";
            });
            $("#block-discount .content").toggle();
        });

        $("#review-tab").on("click", function () {
            $(".question-form").addClass("d-none");
            $("#comments").removeClass("d-none");
            $("#review_form_wrapper").addClass("d-none");
        });
        $("#question-tab").on("click", function () {
            $("#review_form_wrapper").addClass("d-none");
            $(".question-list").removeClass("d-none");
            $(".question-form").addClass("d-none");
        });
        $("#review").on("click", function () {
            $("#review-tab").click();
            $(".question-form").addClass("d-none");
            $("#review_form_wrapper").removeClass("d-none");
        });
        $("#question").on("click", function () {
            $("#question-tab").click();
            $(".question-form").removeClass("d-none");
            $("#review_form_wrapper").addClass("d-none");
        });
        $(".wc-address-book-add-billing-button").each(function () {
            var linkText = $(this).text().trim();
            $(this).html("<span>" + linkText + "</span>");
        });
        $(".wc-address-book-add-shipping-button").each(function () {
            var linkText = $(this).text().trim();
            $(this).html("<span>" + linkText + "</span>");
        });
        $(".wc-address-book-make-primary").on("click", function () {
            setTimeout(function () {
                location.reload();
            }, 1000);
        });
        $(".address-edit-form").submit(function (event) {
            event.preventDefault(); // Prevent form submission and page reload
            $(".address-required").remove();
            var error = false;

            $(".required-field").each(function () {
                if ($(this).parent().parent().is(":visible")) {
                    if (this.value === "") {
                        error = true;
                        $(this)
                            .parent()
                            .append(
                                '<p class="address-required">This field is required.</p>'
                            );
                    }
                } else {
                    if (this.value === "") {
                        console.log("Hidden required field found");
                    }
                }
            });

            if (error === false) {
                this.submit();
            }
        });

        $("#commentform").submit(function (event) {
            $(".required-error").remove();
            var googleResponse = $("#commentform .g-recaptcha-response").val();
            if (!googleResponse) {
                $(".captcha-error").html(
                    '<p style="color:red" class="required-error">Please fill up the captcha.</p>'
                );
                event.preventDefault();
            }
            $("#commentform p input").each(function () {
                if (this.value === "") {
                    $(this)
                        .parent()
                        .append(
                            '<p style="color:red" class="required-error">This field is required.</p>'
                        );
                    event.preventDefault();
                }
            });
            var comment = $("#commentform #comment").val();
            if (!comment) {
                $(".comment-form-comment").append(
                    '<p style="color:red" class="required-error">This field is required.</p>'
                );
                event.preventDefault();
            }
        });

        /*Quick Order page quantity*/
        $(".wqty .plus").on("click", function (e) {
            var xvar = parseInt($(this).parent().find(".qty").val());
            $(this)
                .parent()
                .find(".qty")
                .val(xvar + 1);
        });

        $(".wqty").on("click", ".minus", function (e) {
            var xvar = parseInt($(this).parent().find(".qty").val());
            if (xvar !== 1) {
                $(this)
                    .parent()
                    .find(".qty")
                    .val(xvar - 1);
            }
        });
        var $bankTransfer = $("#payment_details-bank-transfer");
        if ($bankTransfer.prop("checked")) {
            $bankTransfer.click();
        }

        // Check if the PayPal radio button should be programmatically clicked
        var $paypal = $("#payment_details-paypal");
        if ($paypal.prop("checked")) {
            $paypal.click();
        }

        if ($(".single-product").hasClass("sale")) {
            var price_html = $(
                ".elementor-widget-woocommerce-product-price ins .woocommerce-Price-amount.amount"
            ).text();
            var product_id = $(
                ".e-atc-qty-button-holder .single_add_to_cart_button"
            ).val();
            $(".e-atc-qty-button-holder").addClass("nshow");
            $(
                ".e-atc-qty-button-holder .single_add_to_cart_button"
            ).replaceWith(
                '<button type="submit" name="add-to-cart" value="' +
                    product_id +
                    '" class="single_add_to_cart_button elementor-button button alt nbot"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Buy Now <span class="woocommerce-Price-amount amount">' +
                    price_html +
                    "</span></span></button>"
            );
        }

        $(".price li.one-time-option").each(function () {
            if ($(this).find('input[type="radio"]').is(":checked")) {
                console.log("one");
                $(this).show();
                $(this).parent().find("li.subscription-option").remove();
                var price_html = $(
                    ".elementor-widget-woocommerce-product-price .woocommerce-Price-amount.amount"
                ).text();
                var product_id = $(
                    ".e-atc-qty-button-holder .single_add_to_cart_button"
                ).val();
                $(".e-atc-qty-button-holder").addClass("nshow");
                $(
                    ".e-atc-qty-button-holder .single_add_to_cart_button"
                ).replaceWith(
                    '<button type="submit" name="add-to-cart" value="' +
                        product_id +
                        '" class="single_add_to_cart_button elementor-button button alt nbot"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Buy Now <span class="woocommerce-Price-amount amount">' +
                        price_html +
                        "</span></span></button>"
                );
            }
        });

        $(".price li.subscription-option").each(function () {
            if ($(this).find('input[type="radio"]').is(":checked")) {
                console.log("subs");
                $(this).parent().find("li.one-time-option").remove();
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find(".tool-tiptext .prices-tier .item")
                    .hide();
                $(this).parent().parent().parent().addClass("withsubs");
            }
            $(this).show();
        });

        $(".wcsatt-options-prompt-radios li.wcsatt-options-prompt-radio").each(
            function () {
                if ($(this).find('input[type="radio"]').is(":checked")) {
                    console.log("one");
                    $(this).show();
                    $(this).parent().find("li.subscription-option").remove();
                    var price_html = $(
                        ".elementor-widget-woocommerce-product-price .woocommerce-Price-amount.amount"
                    ).text();
                    var product_id = $(
                        ".e-atc-qty-button-holder .single_add_to_cart_button"
                    ).val();
                    $(
                        ".elementor-widget-woocommerce-product-price .woocommerce-Price-amount.amount"
                    ).text();
                    $(".e-atc-qty-button-holder").addClass("nshow");
                    $(
                        ".e-atc-qty-button-holder .single_add_to_cart_button"
                    ).replaceWith(
                        '<button type="submit" name="add-to-cart" value="' +
                            product_id +
                            '" class="single_add_to_cart_button elementor-button button alt nbot"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Buy Now <span class="woocommerce-Price-amount amount">' +
                            price_html +
                            "</span></span></button>"
                    );
                }
            }
        );

        $(".wcsatt-options-prompt-radio input[type=radio]").on(
            "change",
            function () {
                var rval = $(this).val();
                var product_id = $(
                    ".e-atc-qty-button-holder .single_add_to_cart_button"
                ).val();
                var sym = $(
                    ".elementor-widget-woocommerce-product-price .woocommerce-Price-currencySymbol"
                )
                    .first()
                    .text();
                var price_html = $(
                    ".elementor-widget-woocommerce-product-price .woocommerce-Price-amount.amount"
                ).text();
                var nprice = $(
                    ".wcsatt-options-product-dropdown :selected"
                ).text();
                if (rval == "yes") {
                    const array = nprice.split(" ");
                    var xprice = array[3];
                    if (xprice.indexOf("for") >= 0) {
                        xprice = array[4];
                    }
                    price_html = xprice;
                }
                if (price_html.length > 10) {
                    const arr = price_html.split(sym);
                    if (price_html.indexOf(sym) >= 0) {
                        price_html = sym + "" + arr[1];
                    }
                }
                $(".e-atc-qty-button-holder").addClass("nshow");
                $(
                    ".e-atc-qty-button-holder .single_add_to_cart_button"
                ).replaceWith(
                    '<button type="submit" name="add-to-cart" value="' +
                        product_id +
                        '" class="single_add_to_cart_button elementor-button button alt nbot"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Buy Now <span class="woocommerce-Price-amount amount">' +
                        price_html +
                        "</span></span></button>"
                );
            }
        );

        $(".wcsatt-options-product-dropdown").on("change", function () {
            var product_id = $(
                ".e-atc-qty-button-holder .single_add_to_cart_button"
            ).val();
            var sym = $(
                ".elementor-widget-woocommerce-product-price .woocommerce-Price-currencySymbol"
            )
                .first()
                .text();
            var nprice = $(this).find("option:selected").text();
            const array = nprice.split(" ");
            var price_html = array[3];
            if (price_html.indexOf("for") >= 0) {
                price_html = array[4];
            }
            if (price_html.length > 10) {
                const arr = price_html.split(sym);
                if (price_html.indexOf(sym) >= 0) {
                    price_html = sym + "" + arr[2];
                }
            }
            $(".e-atc-qty-button-holder").addClass("nshow");
            $(
                ".e-atc-qty-button-holder .single_add_to_cart_button"
            ).replaceWith(
                '<button type="submit" name="add-to-cart" value="' +
                    product_id +
                    '" class="single_add_to_cart_button elementor-button button alt nbot"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Buy Now <span class="woocommerce-Price-amount amount">' +
                    price_html +
                    "</span></span></button>"
            );
        });

        //product review/ratings link
        $(".woocommerce-product-rating .custom-star-rating").wrapInner(
            "<a href='#reviews'></a>"
        );
        var rev = $(
            ".woocommerce-product-rating .woocommerce-review-link .count"
        ).text();
        if (rev == 0) {
            $(".woocommerce-product-rating").hide();
        } else {
            $(".woocommerce-product-rating .woocommerce-review-link").html(
                '<span class="count">' + rev + "</span> Reviews"
            );
            $(".woocommerce-product-rating").show();
            $(".woocommerce-product-rating .woocommerce-review-link").show();
        }
    });
})(jQuery);
