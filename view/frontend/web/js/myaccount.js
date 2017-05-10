define([
        'ko',
        'uiComponent',
        'mage/url',
        'mage/storage'
    ],
    function (ko, Component, urlBuilder,storage) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'MagentoEse_MyAccountWidget/myaccount'
            },

            customerData: ko.observableArray([]),

            getCustomerData: function () {
                var self = this;
                var serviceUrl = urlBuilder.build('magentoese_myaccountwidget/data/customer');
                return storage.post( serviceUrl, '' )
                    .done( function (response) {
                        self.customerData.push(JSON.parse(response));
                    } )
                    .fail( function (response) {
                        alert(response);
                    } );
            }
        });
    });