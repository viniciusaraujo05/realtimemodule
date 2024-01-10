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
                        src: productData.imageUrl,
                        stockQty: productData.stockQty
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
