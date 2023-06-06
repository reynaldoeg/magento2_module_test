define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_CheckoutAgreements/js/model/agreements-assigner',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/url-builder',
    'mage/url',
    'Magento_Checkout/js/model/error-processor',
    'uiRegistry'
], function (
    $,
    wrapper,
    agreementsAssigner,
    quote,
    customer,
    urlBuilder,
    urlFormatter,
    errorProcessor,
    registry
) {
    'use strict';

    return function (placeOrderAction) {

        /** Override default place order action and add agreement_ids to request */
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            agreementsAssigner(paymentData);
            let isCustomer = customer.isLoggedIn();
            let quoteId = quote.getQuoteId();

            let url = urlFormatter.build('chupaprecios/quote/save');

            let deliveryNote = $('[name="extension_attributes[delivery_note]"]').val();
            let phoneType = $('[name="extension_attributes[phone_type]"]').val();

            if (phoneType) {

                let payload = {
                    'cartId': quoteId,
                    'delivery_note': deliveryNote,
                    'phone_type': phoneType,
                    'is_customer': isCustomer
                };

                if (!payload.phone_type) {
                    return true;
                }

                let result = true;

                $.ajax({
                    url: url,
                    data: payload,
                    dataType: 'text',
                    type: 'POST',
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );
            }

            return originalAction(paymentData, messageContainer);
        });
    };
});
