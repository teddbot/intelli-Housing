$(document).ready(function () {
    $(document).on('change', '#type_id', event => {
        if ($('#type_id').children('option:selected').data('code') == 'rent') {
            $('#period').closest('.period-form-group').removeClass('hidden').fadeIn();
        } else {
            $('#period').closest('.period-form-group').addClass('hidden').fadeOut();
        }
    });

    $(document).on('change', '#never_expired', event => {
        if ($(event.currentTarget).is(':checked') === true) {
            $('#auto_renew').closest('.auto-renew-form-group').addClass('hidden').fadeOut();
        } else {
            $('#auto_renew').closest('.auto-renew-form-group').removeClass('hidden').fadeIn();
        }
    });

    $('body')
        .on('change', '#property-category', function () {
            let _this = $(this);
            if ($('#property-sub-category').length < 1) {
                return;
            }

            $.ajax({
                url: _this.data('url'),
                data: {
                    id: _this.val()
                },
                beforeSend: () => {
                    $('#property-sub-category').html('<option value="">' + ($('#property-sub-category').data('placeholder')) + '</option>');
                },
                success: data => {
                    let option = '<option value="">' + ($('#property-sub-category').data('placeholder')) + '</option>';
                    $.each(data.data, (index, item) => {
                        option += '<option value="' + item.id + '">' + item.name + '</option>';
                    });

                    $('#property-sub-category').html(option).select2();
                }
            });
        })
        .on('change', 'select#filter_country_id', function () {
            let _this = $(this);

            $.ajax({
                url: $('#filter_state_id').data('url'),
                data: {
                    id: _this.val()
                },
                beforeSend: () => {
                    $('#filter_state_id').html('<option value="">' + ($('#filter_state_id').data('placeholder')) + '</option>');
                    $('#filter_city_id').html('<option value="">' + ($('#filter_city_id').data('placeholder')) + '</option>');
                },
                success: data => {
                    let option = '<option value="">' + ($('#filter_state_id').data('placeholder')) + '</option>';
                    $.each(data.data, (index, item) => {
                        option += '<option value="' + item.id + '">' + item.name + '</option>';
                    });

                    $('#filter_state_id').html(option).select2();
                }
            });
        })
        .on('change', 'select#filter_state_id', function () {
            let _this = $(this);

            $.ajax({
                url: $('#filter_city_id').data('url'),
                data: {
                    id: _this.val()
                },
                beforeSend: () => {
                    $('#filter_city_id').html('<option value="">' + ($('#filter_city_id').data('placeholder')) + '</option>');
                },
                success: data => {
                    let option = '<option value="">' + ($('#filter_city_id').data('placeholder')) + '</option>';
                    $.each(data.data, (index, item) => {
                        option += '<option value="' + item.id + '">' + item.name + '</option>';
                    });

                    $('#filter_city_id').html(option).select2();
                }
            });
        })
        .on('click', 'button.btn-get-latitude-longitude', function (event) {
            event.preventDefault();
            let addressStreet = $('.main-form #location').val()
            let addressCity = $('.main-form #city_id option:selected').text();
            let address = addressStreet + ', ' + addressCity;
            let googleGeoApiKey = $(this).data('key');

            if (addressStreet === '') {
                toastr.error(window.trans.please_enter_address !== undefined ? window.trans.please_enter_address : 'Please enter address');
                return;
            }

            fetch("https://maps.googleapis.com/maps/api/geocode/json?address=" + address + '&key=' + googleGeoApiKey)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'OK') {
                        const latitude = data.results[0].geometry.location.lat;
                        const longitude = data.results[0].geometry.location.lng;
                        $('.main-form input#latitude').val(latitude);
                        $('.main-form input#longitude').val(longitude);
                    } else {
                        toastr.error(window.trans.address_invalid !== undefined ? window.trans.address_invalid : 'Address invalid');
                    }
                })
        });
});
