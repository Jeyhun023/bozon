$(document).ready(function () {
    // $("#FilUploader").change(function () {
    //     var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
    //     if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
    //         alert("Only formats are allowed : " + fileExtension.join(', '));
    //     }
    // });
    // date select
    $(function () {
        $('input[name="daterange"]').daterangepicker({
                opens: "left",
            },
            function (start, end, label) {
                console.log(
                    "A new date selection was made: " +
                    start.format("YYYY-MM-DD") +
                    " to " +
                    end.format("YYYY-MM-DD")
                );
            }
        );

        $(".dropdown-header").click(function () {
            $(".dropdown-body").slideToggle();
        });
    });
    // login password
    $(".toggle-password").click(function () {
        $(this).toggleClass("active");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    // selectbox
    var selectHolder = $(".selectHolder");
    selectHolder.each(function () {
        var currentSelectHolder = $(this);
        var select = currentSelectHolder.find("select");
        var options = select.children();
        var selected_option = select.find("option:checked");

        // SELECT HEADER
        var selectHeader = $("<h5></h5>");
        selectHeader.addClass("select_header");
        selectHeader.html(selected_option.html());
        currentSelectHolder.append(selectHeader);
        // SELECT BODY HOLDER
        var selectBodyHolder = $("<div></div>");
        selectBodyHolder.addClass("select_body_holder");
        currentSelectHolder.append(selectBodyHolder);
        // SELECT BODY
        var selectBody = $("<ul></ul>");
        selectBody.addClass("select_body");
        options.each(function () {
            var option_text = $(this).html();
            var value = $(this).attr("value");
            var disabled = $(this).attr("disabled");
            var li = $("<li></li>");
            li.append(option_text);
            li.attr("data-value", value);
            if (disabled) {
                li.attr("data-disabled", "true");
            } else {
                li.attr("data-disabled", "false");
            }
            selectBody.append(li);
        });
        selectBodyHolder.append(selectBody);
    });
    // CLICK SELECT HEADER
    $(document).on("click", ".select_header", function () {
        $(".selectHolder .select_header").not($(this)).removeClass("active");
        $(".selectHolder .select_body_holder")
            .not($(this).next(0))
            .removeClass("active");
        $(this).toggleClass("active");
        $(this).next(0).toggleClass("active");
    });
    // CLICK SELECT BODY ITEM
    $(document).on("click", ".select_body li", function () {
        var select = $(this).parents(".select_body_holder").prevAll().eq(1);
        if (!$(this).data("disabled")) {
            select.val($(this).data("value")).trigger("change");
            $(this)
                .parents(".select_body_holder")
                .prev()
                .html($(this).html())
                .removeClass("active");
            $(this).parents(".select_body_holder").removeClass("active");
        }
    });

    $(document).on("click", function (e) {
        var target = $(e.target);
        if (
            !(
                target.hasClass("selectHolder") ||
                target.parents(".selectHolder").length
            )
        ) {
            $(".selectHolder").children().removeClass("active");
        }
    });

    approval = () => {
        $(".popup-1").addClass("active");
        $("body").addClass("active");
        console.log(".popup-1");
    };

    save = () => {
        $(".popup-2").addClass("active");
        $("body").addClass("active");
    };
    successSave = () => {
        $(".popup-3").addClass("active");
        $("body").addClass("active");
    };
    deletepop = () => {
        $(".popup-4").addClass("active");
        $("body").addClass("active");
    };
    deleted = () => {
        $(".popup-5").addClass("active");
        $("body").addClass("active");
    };
    createStory = () => {
        $(".popup-6").addClass("active");
        $("body").addClass("active");
    };

    $(".popup-close").click(function () {
        $(".popup").removeClass("active");
        $("body").removeClass("active");
    });
    //   $(".layer-popup").click(function(){
    //     $(".popup").removeClass("active");
    //     $("body").removeClass("active");
    //   })

    $("#left-menu-slide li a").click(function () {
        var target = $(this).attr("href");
        $(this).addClass("active");
        $("#left-menu-slide li a").not($(this)).removeClass("active");

        $("html, body")
            .stop()
            .animate({
                    scrollTop: $(target).offset().top,
                },
                300,
                function () {
                    location.hash = target;
                }
            );
    });

    $('.checkbox-table').on("change", function () {
        if ($('.checkbox-table').is(":checked")) {
            $(".delete-search-result").addClass("active");
        } else {
            $(".delete-search-result").removeClass("active");
        }
    });


    $("#checkParent").click(function () {
        $(".checkbox-table:checkbox").not(this).prop("checked", this.checked);
    });

    opencreatePOPUP = (cls_popup, cls_form, url, cls_text, text) => {
        $(cls_form).attr('action', url);
        $(cls_text).text(text);
        $(cls_popup).addClass("active");
        $("body").addClass("active");
    }

    opencreatePOPUP2 = (cls_popup) => {
        $(cls_popup).addClass("active");
        $("body").addClass("active");
    }

    openupdatePOPUP = (cls_popup, cls_form, url, cls_text, text, cls_id, cls_url, item, for_banner = null) => {
        $(cls_form).attr('action', url);
        $(cls_text).text(text);
        $(cls_id).val(item.id);
        $(cls_url).val(item.url);
        if (for_banner) {
            $('.sira_input2').val(item.sira);
            $('.title_input2').val(item.title);
        }
        $(cls_popup).addClass("active");
        $("body").addClass("active");
    }

    openupdateRegions = (cls_popup, cls_form, url, cls_text, text, cls_id, cls_name, cls_price, item) => {
        $(cls_form).attr('action', url);
        $(cls_text).text(text);
        $(cls_id).val(item.id);
        $(cls_name).val(item.name);
        $(cls_price).val(item.deliver_price);
        $(cls_popup).addClass("active");
        $("body").addClass("active");
    }

    opendeletePOPUP = (url, child = false) => {
        $("#deleteformdinamic").attr('action', url);
        if (child) {
            $('.pop-p2').show();
        }else{
            $('.pop-p2').hide();
        }
        $('.popup-delete').addClass("active");
        $("body").addClass("active");
    }

    $(".formcreatecity").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        console.log(form)
        let deliverySaveBtn = form.find(".drt");
        deliverySaveBtn.attr('disabled', true);
        fetch(form.attr('action'), {
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(function (response) {
                console.log(response)
                console.log("K")
                if (response.success) {
                    $("body").removeClass("active");

                    $('.url_error').addClass('display-none');
                    $('.url_input').removeClass('error-input');
                    $('.image_error').addClass('display-none');
                    $('.image_input').removeClass('error-input');

                    location.reload();
                } else {
                    if (response.errors.hasOwnProperty('name')) {
                        $('.name_error').removeClass('display-none');
                        $('.name_error').text(response.errors.name[0]);
                        $('.name_input').addClass('error-input');
                    } else {
                        $('.name_error').addClass('display-none');
                        $('.name_input').removeClass('error-input');
                    }
                }
            })
            .catch(error => {
                console.log(error)
                console.error('Error:', error);
            });
        deliverySaveBtn.attr('disabled', false);
        deliverySaveBtn.html('Yadda saxla');
        // $(".popup-6").removeClass('active');
        return false;
    });

    $(".formcreatecity2").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        console.log(form.attr('action'))
        console.log(form.attr('method'))
        let deliverySaveBtn = form.find(".drt2");
        deliverySaveBtn.attr('disabled', true);
        fetch(form.attr('action'), {
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(function (response) {
                console.log(response)
                console.log("K")
                if (response.success) {
                    $("body").removeClass("active");

                    $('.name_error').addClass('display-none');
                    $('.name_input').removeClass('error-input');
                    $('.price_error').addClass('display-none');
                    $('.price_input').removeClass('error-input');

                    location.reload();
                } else {
                    if (response.errors.hasOwnProperty('name')) {
                        $('.name_error').removeClass('display-none');
                        $('.name_error').text(response.errors.name[0]);
                        $('.name_input').addClass('error-input');
                    } else {
                        $('.name_error').addClass('display-none');
                        $('.name_input').removeClass('error-input');
                    }
                }
            })
            .catch(error => {
                console.log(error)
                // console.error('Error:', error);
            });
        deliverySaveBtn.attr('disabled', false);
        deliverySaveBtn.html('Yadda saxla');
        // $(".popup-6").removeClass('active');
        return false;
    });

    $(".formcreatebanner").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        console.log(form)
        let deliverySaveBtn = form.find(".drt");
        deliverySaveBtn.attr('disabled', true);
        fetch(form.attr('action'), {
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(function (response) {
                console.log(response)
                console.log("K")
                if (response.success) {
                    $("body").removeClass("active");

                    $('.url_error').addClass('display-none');
                    $('.url_input').removeClass('error-input');
                    $('.image_error').addClass('display-none');
                    $('.image_input').removeClass('error-input');

                    location.reload();
                } else {
                    if (response.errors.hasOwnProperty('url')) {
                        $('.url_error').removeClass('display-none');
                        $('.url_error').text(response.errors.url[0]);
                        $('.url_input').addClass('error-input');
                    } else {
                        $('.url_error').addClass('display-none');
                        $('.url_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('main_image')) {
                        $('.image_error').removeClass('display-none');
                        $('.image_error').text(response.errors.main_image[0]);
                        $('.image_input').addClass('error-input');
                    } else {
                        $('.image_error').addClass('display-none');
                        $('.image_input').removeClass('error-input');
                    }
                }
            })
            .catch(error => {
                console.log(error)
                console.error('Error:', error);
            });
        deliverySaveBtn.attr('disabled', false);
        deliverySaveBtn.html('Yadda saxla');
        // $(".popup-6").removeClass('active');
        return false;
    });
    $(".formcreatebanner2").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        console.log(form.attr('action'))
        console.log(form.attr('method'))
        let deliverySaveBtn = form.find(".drt2");
        deliverySaveBtn.attr('disabled', true);
        fetch(form.attr('action'), {
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(function (response) {
                console.log(response)
                console.log("K")
                if (response.success) {
                    $("body").removeClass("active");

                    $('.url_error').addClass('display-none');
                    $('.url_input').removeClass('error-input');
                    $('.image_error').addClass('display-none');
                    $('.image_input').removeClass('error-input');

                    location.reload();
                } else {
                    if (response.errors.hasOwnProperty('url')) {
                        $('.url_error').removeClass('display-none');
                        $('.url_error').text(response.errors.url[0]);
                        $('.url_input').addClass('error-input');
                    } else {
                        $('.url_error').addClass('display-none');
                        $('.url_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('main_image')) {
                        $('.image_error').removeClass('display-none');
                        $('.image_error').text(response.errors.main_image[0]);
                        $('.image_input').addClass('error-input');
                    } else {
                        $('.image_error').addClass('display-none');
                        $('.image_input').removeClass('error-input');
                    }
                }
            })
            .catch(error => {
                console.log(error)
                // console.error('Error:', error);
            });
        deliverySaveBtn.attr('disabled', false);
        deliverySaveBtn.html('Yadda saxla');
        // $(".popup-6").removeClass('active');
        return false;
    });
    $(".formClients").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        let deliverySaveBtn = form.find(".drt2");
        deliverySaveBtn.attr('disabled', true);
        fetch(form.attr('action'), {
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(function (response) {
                console.log(response)
                console.log("K")
                if (response.success) {
                    $("body").removeClass("active");

                    $('.password_error').addClass('display-none');
                    $('.password_input').removeClass('error-input');
                    $('.image_error').addClass('display-none');
                    $('.image_input').removeClass('error-input');
                    $('.prftiterr').addClass('display-none');
                    $('.phone_prf_Err').removeClass('error-input');

                    location.reload();
                } else {
                    if (response.errors.hasOwnProperty('password')) {
                        $('.password_error').removeClass('display-none');
                        $('.password_error').text(response.errors.password[0]);
                        $('.password_input').addClass('error-input');
                    } else {
                        $('.password_error').addClass('display-none');
                        $('.password_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('email')) {
                        $('.email_error').removeClass('display-none');
                        $('.email_error').text(response.errors.email[0]);
                        $('.email_input').addClass('error-input');
                    } else {
                        $('.email_error').addClass('display-none');
                        $('.email_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('phone_prefix') || response.errors.hasOwnProperty('phone_number')) {
                        $('.prftiterr').removeClass('display-none');
                        $('.prftiterr').text("Prefik ve Phone number doldurun");
                        $('.phone_prf_Err').addClass('error-input');
                    } else {
                        $('.prftiterr').addClass('display-none');
                        $('.phone_prf_Err').removeClass('error-input');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        deliverySaveBtn.attr('disabled', false);
        deliverySaveBtn.html('Yadda saxla');
        // $(".popup-6").removeClass('active');
        return false;
    });
    $(".formClients2").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        let deliverySaveBtn = form.find(".drt2");
        deliverySaveBtn.attr('disabled', true);
        fetch(form.attr('action'), {
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(function (response) {
                console.log(response)
                console.log("K")
                if (response.success) {
                    $("body").removeClass("active");

                    $('.password_error').addClass('display-none');
                    $('.password_input').removeClass('error-input');
                    $('.image_error').addClass('display-none');
                    $('.image_input').removeClass('error-input');
                    $('.prftiterr').addClass('display-none');
                    $('.phone_prf_Err').removeClass('error-input');

                    location.reload();
                } else {
                    if (response.errors.hasOwnProperty('password')) {
                        $('.password_error').removeClass('display-none');
                        $('.password_error').text(response.errors.password[0]);
                        $('.password_input').addClass('error-input');
                    } else {
                        $('.password_error').addClass('display-none');
                        $('.password_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('email')) {
                        $('.email_error').removeClass('display-none');
                        $('.email_error').text(response.errors.email[0]);
                        $('.email_input').addClass('error-input');
                    } else {
                        $('.email_error').addClass('display-none');
                        $('.email_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('phone_prefix') || response.errors.hasOwnProperty('phone_number')) {
                        $('.prftiterr').removeClass('display-none');
                        $('.prftiterr').text("Prefik ve Phone number doldurun");
                        $('.phone_prf_Err').addClass('error-input');
                    } else {
                        $('.prftiterr').addClass('display-none');
                        $('.phone_prf_Err').removeClass('error-input');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        deliverySaveBtn.attr('disabled', false);
        deliverySaveBtn.html('Yadda saxla');
        // $(".popup-6").removeClass('active');
        return false;
    });
    $(".foradmin").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(form[0]);
        let deliverySaveBtn = form.find(".drt2");
        deliverySaveBtn.attr('disabled', true);
        fetch(form.attr('action'), {
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'accept': 'application/json'
            },
            body: formData,
        })
            .then(response => response.json())
            .then(function (response) {
                console.log(response)
                console.log("K")
                if (response.success) {
                    $("body").removeClass("active");

                    $('.password_error').addClass('display-none');
                    $('.password_input').removeClass('error-input');
                    $('.image_error').addClass('display-none');
                    $('.image_input').removeClass('error-input');
                    $('.prftiterr').addClass('display-none');
                    $('.phone_prf_Err').removeClass('error-input');
                    $('.role_error').addClass('display-none');
                    $('.role2_error').removeClass('error-input');

                    location.reload();
                } else {
                    if (response.errors.hasOwnProperty('password')) {
                        $('.password_error').removeClass('display-none');
                        $('.password_error').text(response.errors.password[0]);
                        $('.password_input').addClass('error-input');
                    } else {
                        $('.password_error').addClass('display-none');
                        $('.password_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('email')) {
                        $('.email_error').removeClass('display-none');
                        $('.email_error').text(response.errors.email[0]);
                        $('.email_input').addClass('error-input');
                    } else {
                        $('.email_error').addClass('display-none');
                        $('.email_input').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('phone_prefix') || response.errors.hasOwnProperty('phone_number')) {
                        $('.prftiterr').removeClass('display-none');
                        $('.prftiterr').text("Prefik ve Phone number doldurun");
                        $('.phone_prf_Err').addClass('error-input');
                    } else {
                        $('.prftiterr').addClass('display-none');
                        $('.phone_prf_Err').removeClass('error-input');
                    }
                    if (response.errors.hasOwnProperty('role')) {
                        $('.role_error').removeClass('display-none');
                        $('.role_error').text("Prefik ve Phone number doldurun");
                        $('.role2_error').addClass('error-input');
                    } else {
                        $('.role_error').addClass('display-none');
                        $('.role2_error').removeClass('error-input');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        deliverySaveBtn.attr('disabled', false);
        deliverySaveBtn.html('Yadda saxla');
        // $(".popup-6").removeClass('active');
        return false;
    });

    deletepop40 = (url, storage, child = false) => {
        console.log(child)
        $('.pir').data('url', url);
        $('.pir').data('storage', storage);
        if (child) {
            $('.pop-p3').show();
        }
        $(".popup-40").addClass("active");
        $("body").addClass("active");
    }

    client_update = (item, url, role = null) => {
        $('#ni1').val(item.full_name);
        $('#frid').val(item.id);
        $('#em1').val(item.email);
        if (role) {
            $('.role_value').text(role);
        }
        $('#val_phone').text(item.phone_number);
        $('.fr2').attr('action', url);
        $(".popup-u2").addClass("active");
        $("body").addClass("active");
    }

    function arrayRemove(arr, value) {
        return arr.filter(function (ele) {
            return ele != value;
        });
    }

    checkInput = (sessionStorageName, id, prefixOfNode) => {
        var keys = window.sessionStorage.getItem(sessionStorageName);
        if (keys) {
            var ar = keys.split(',');
            ar = ar.filter((item) => {
                return item != id
            })
            if ($(prefixOfNode + id).is(':checked')) {
                ar.push(id)
            }
            ar = ar.join(',');
            window.sessionStorage.setItem(sessionStorageName, ar);
        } else {
            window.sessionStorage.setItem(sessionStorageName, id);
        }
    }

    window.sessionStorage.setItem("banner", '');
    window.sessionStorage.setItem("user", '');
    window.sessionStorage.setItem("admin", '');
    window.sessionStorage.setItem("magaza", '');
    window.sessionStorage.setItem("blog", '');
    window.sessionStorage.setItem("vacancy", '');
    window.sessionStorage.setItem("con", '');
    window.sessionStorage.setItem("appeal", '');
    window.sessionStorage.setItem("seluser", '');
    window.sessionStorage.setItem("category", '');

    sdAll = (sessionStorageName, value, check_all_class, node_class_checkboxs) => {
        if ($(check_all_class).is(':checked')) {
            window.sessionStorage.setItem(sessionStorageName, value);
            $(node_class_checkboxs).not(this).prop('checked', true);
        } else {
            var ke = window.sessionStorage.getItem(sessionStorageName);
            window.sessionStorage.setItem(sessionStorageName, '');
            $(node_class_checkboxs).not(this).prop('checked', false);
        }
    };

    // tinymce.init({
    //     selector: '.mytextarea'
    // });
});

var value = 1;
var feature = 1;
function loadFeatureValue(id) {
    value += 1;
    $('#newvalue_'+id).addClass("new-address-content-input-groups").attr("id","value_div_"+value)
    .append( "<div class='news-address-content-inputs'><label for='' class='f-size-14-b c-dblack-op-75 mb-12'>Value</label><input type='text' class='input-class' name='"+id+"[values]["+value+"]'></div><div class='news-address-content-inputs' style='margin-top:20px;'><button class='delete-search-result active' type='button' onclick='removeValue("+value+")'><svg width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'><g><path d='M5.25714 3.32143V1.92857C5.25714 1.41574 5.66648 1 6.17143 1H9.82857C10.3335 1 10.7429 1.41574 10.7429 1.92857V3.32143M1 3.78571H15M3.37143 3.78571V13.0714C3.37143 13.5843 3.78077 14 4.28571 14H11.7143C12.2192 14 12.6286 13.5843 12.6286 13.0714V3.78571M8 6.62958V10.2277V11.4175' stroke='#05061E'></path></g></svg><span class='f-size-14'>Sil</span></button></div>" )
    .after("<div id='newvalue_"+id+"'></div>");
}
function removeValue(id) {
    $( "#value_div_"+id ).remove();
}

function loadFeature() {
    feature += 1;
    $('#newfeature_'+ (feature - 1)).attr("id","feature_div_"+feature).css('margin-top', '50px')
    .append( "<button class='delete-search-result active' onclick='removeFeature("+feature+")'><svg width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'><g><path d='M5.25714 3.32143V1.92857C5.25714 1.41574 5.66648 1 6.17143 1H9.82857C10.3335 1 10.7429 1.41574 10.7429 1.92857V3.32143M1 3.78571H15M3.37143 3.78571V13.0714C3.37143 13.5843 3.78077 14 4.28571 14H11.7143C12.2192 14 12.6286 13.5843 12.6286 13.0714V3.78571M8 6.62958V10.2277V11.4175' stroke='#05061E'></path></g></svg><span class='f-size-14'>Sil</span></button></br><div class='new-address-content-input-groups'><div class='news-address-content-inputs'><label for='' class='f-size-14-b c-dblack-op-75 mb-12'>Ad</label><input type='text' class='input-class' name='"+feature+"[name]'></div><div class='news-address-content-inputs'><label for='' class='f-size-14-b c-dblack-op-75 mb-12'>Sıra</label><input type='number' class='input-class' name='"+feature+"[sort]'></div></div><div class='new-address-content-input-groups'><div class='news-address-content-inputs'><label for='' class='f-size-14-b c-dblack-op-75 mb-12'>Value</label><input type='text' class='input-class' name='"+feature+"[values][1]'></div><div class='news-address-content-inputs' style='margin-top:20px;'></div></div><div id='newvalue_"+feature+"'></div><a style='color:blue;cursor:pointer' onclick='loadFeatureValue("+feature+")'><h3>+ Yeni dəyər əlavə et</h3></a></br>" )
    .after("<div id='newfeature_"+feature+"'></div>");
}
function removeFeature(id) {
    $( "#feature_div_"+id ).remove();
}

function json2string(json) {
    text = "";
    if (json != '') {
        let errors = json;
        for (var key in errors) {
            text += errors[key][0] + '<br>';
        }
    }
    return text;
}

$("#feature-create-form").submit(function (e) {
    e.preventDefault();
    var form = $(this);
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            dataType: 'json',  
            data: new FormData( this ),
            processData: false,
            contentType: false,
            headers: {
                'X-CSRFToken': $('input[name="csrfToken"]').attr('value') 
            },
            beforeSend: function () {
                $('#sendButton').html("Göndərilir...").attr("disabled", true);
            },
            success: function (response) {
                $('#sendButton').html("Göndərildi");
				history.back();
            },
            error: function (response) {
                $('#sendButton').html("Yadda saxla").attr("disabled", false);
                $(".popup-6").addClass("active");
                $("body").addClass("active");
                $("#errors").html(json2string(response.responseJSON.errors));
            }
        });
    return false;
});