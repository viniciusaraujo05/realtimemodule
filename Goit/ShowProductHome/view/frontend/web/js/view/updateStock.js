define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
    'jquery'
], function (ko, Component, urlBuilder, storage, $) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Goit_ShowProductHome/product',
        },

        product: ko.observable({}),

        initialize: function () {
            this._super();
            this.getProduct();
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
                        src: productData.src,
                        url: productData.url
                    });

                    setTimeout(function () {
                        self.getProduct();
                    }, 5000);
                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        },
    });
});
