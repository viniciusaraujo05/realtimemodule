define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage'
], function (ko, Component, urlBuilder, storage) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Goit_ShowProductHome/product',
        },

        product: ko.observable({
            name: '',
            price: '',
            stockQty: '',
            src: ''
        }),

        initialize: function () {
            this._super(); 
            console.log(this.getProduct);
                
            setInterval(this.getProduct(), 1000);
        },

        getProduct: function () {
            var self = this;
            var serviceUrl = urlBuilder.build('showproduct/showproduct/index');
            return storage.post(
                serviceUrl,
            ).done(
                function (response) {
                    var productData = JSON.parse(response);

                    self.product({
                        name: productData.name,
                        price: productData.price,
                        stockQty: productData.stockQty,
                        src: productData.src
                    });
                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        },
    });
});
