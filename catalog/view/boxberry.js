document.addEventListener('DOMContentLoaded', function() {
    $(document).on('click', 'a[data-boxberry-open=true]', function (e) {
        e.preventDefault();
        let selectPointLink = e.target;
        selectPointFnc(selectPointLink);
    });

    $(document).ajaxComplete(function () {
        let checkedShippingMethod = $("input[name=shipping_method]:checked").val();
        if (checkedShippingMethod !== undefined) {
            if (checkedShippingMethod.includes('boxberry.pickup')) {
                renderBlocks();
                setReadonly();
            } else {
                renderBlocks();
            }
        }
    });

    $(document).on('click', "input[name=shipping_method]", function () {
        let checkedShippingMethod = $("input[name=shipping_method]:checked").val();
        if (checkedShippingMethod === 'boxberry.pickup') {
            selectPointFnc($('#boxberry-issue_point-link')[0])
        } else if (checkedShippingMethod === 'boxberry.pickup_prepaid') {
            selectPointFnc($('#boxberry-issue_point-link-prepaid')[0])
        }
        renderBlocks();
    });

    function setReadonly (address) {
        if (address !== undefined) {
            if ($('.simplecheckout-block-content').length) {
                $('#shipping_address_address_1').val(address).attr('readonly', true);
            } else if ($('#onepcheckout').length) {
                $("#input-payment-address-1").val(address).attr('readonly', true);
            } else {
                if($('#input-shipping-address-1').length) {
                    $('#input-shipping-address-1').val(address);
                }
                if ($('#input-payment-address-1').length) {
                    $('#input-payment-address-1').val(address);
                }
            }
        } else {
            if ($('.simplecheckout-block-content').length) {
                $('#shipping_address_address_1').attr('readonly', true);
            }
            if ($('#onepcheckout').length) {
                $("#input-payment-address-1").attr('readonly', true);
            }
        }
    }

    function renderBlocks () {
        let bbPickupDiv = $("input[name='shipping_method'][value='boxberry.pickup']")
        let bbPickupPrepaidDiv = $("input[name='shipping_method'][value='boxberry.pickup_prepaid']");

        if (!bbPickupDiv.prop("checked")) {
            $('#boxberry-issue_point-block').hide();
        }
        if (!bbPickupPrepaidDiv.prop("checked")) {
            $('#boxberry-issue_point-prepaid-block').hide()
        }
        if (bbPickupDiv.prop("checked")) {
            $('#boxberry-issue_point-link').show();
        }
        if (bbPickupPrepaidDiv.prop("checked")) {
            $('#boxberry-issue_point-link-prepaid').show()
        }
        if (!bbPickupDiv.prop("checked")) {
            $('#boxberry-issue_point-link').hide();
        }
        if (!bbPickupPrepaidDiv.prop("checked")) {
            $('#boxberry-issue_point-link-prepaid').hide()
        }
    }

    function selectPointFnc (selectPointLink) {
        let classname  = selectPointLink.getAttribute('data-type');
        let city       = selectPointLink.getAttribute('data-boxberry-city').replace('ё', 'е');
        let token      = selectPointLink.getAttribute('data-boxberry-token');
        // let targetStart = selectPointLink.getAttribute('data-boxberry-target-start');
        let order_id   = selectPointLink.getAttribute('data-order-id');
        let weight     = selectPointLink.getAttribute('data-boxberry-weight');
        let width      = selectPointLink.getAttribute('data-boxberry-width');
        let height     = selectPointLink.getAttribute('data-boxberry-height');
        let depth      = selectPointLink.getAttribute('data-boxberry-length');
        let paymentSum = selectPointLink.getAttribute('data-paymentsum');
        let orderSum   = selectPointLink.getAttribute('data-ordersum');
        let sucrh      = selectPointLink.getAttribute('data-sucrh');
        let api        = selectPointLink.getAttribute('data-api-url');
        if (selectPointLink.getAttribute('data-class') === 'boxberryDeliverySelf') {
            paymentSum = orderSum;
        } else {
            paymentSum = "0";
        }
        let boxberryPointSelectedHandler = function (result) {
            let addressSplit = result.address.split(',');
            let insertAddress = '# ' + result.id + ' ' + addressSplit[2].trim() + (addressSplit[3] !== undefined ? addressSplit[3] : '');
            let prepaid = paymentSum === '0' ? '-prepaid' : '';

            $.ajax({
                url: "index.php?route=extension/boxberry/shipping/Boxberry.selectIssuePoint&issue_point_id=" + encodeURIComponent(result.id) + "&prepaid=" + (paymentSum !== "0" ? "0" : "1"),
                success: function () {
                    $('#boxberry-issue_point' + prepaid + '-block').show();
                    $('#boxberry-issue_point'+ prepaid + '-name').text(result.name);
                    if (result.id.indexOf('ПП-') >= 0 && $('#boxberry-issue_point' + prepaid + '-addr-short a').length) {
                        $('#boxberry-issue_point' + prepaid + '-addr-short').remove('a').text(addressSplit.slice(2))
                    } else if (!$('#boxberry-issue_point' + prepaid + '-addr-short a').length) {
                        $('#boxberry-issue_point' + prepaid + '-addr-short').html('<a href="https://boxberry.ru/find_an_office/' + result.id + '" target="_blank">' + addressSplit.slice(2) + '</a>');
                    } else {
                        $('#boxberry-issue_point' + prepaid + '-addr-short a').attr('href', 'https://boxberry.ru/find_an_office/' + result.id).text(addressSplit.slice(2));
                    }
                    $('#boxberry-issue_point' + prepaid + '-phone').text('Телефон: ' + result.phone + ', ');
                    $('#boxberry-issue_point' + prepaid + '-work').text('часы работы: ' + result.workschedule);
                    $('#boxberry-issue_point-link' + prepaid).text('Выбрать другой пункт выдачи');

                    setReadonly(insertAddress)
                }
            })
        };

        boxberry.versionAPI(api);
        boxberry.checkLocation(1);
        boxberry.sucrh(sucrh);
        boxberry.open(boxberryPointSelectedHandler, token, city, 0, orderSum, weight, paymentSum, height, width, depth);
    }
});