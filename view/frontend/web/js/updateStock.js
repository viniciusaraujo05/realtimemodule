define([
    'jquery', 
    'uiComponent', 
    'ko'], 
    function ($, Component) {
    'use strict';
    
    return Component.extend({
        defaults: {
            stockEndpoint: '/rest/V1/test/publicendpoint',
            updateInterval: 1000
        },
        initialize: function () {
            setInterval(this.updateStock.bind(this), this.updateInterval);
        },
        updateStock: function () {
            var self = this;
            $.ajax({
                url: this.stockEndpoint,
                type: 'GET',
                contentType: 'application/json',
            })
            .done(function (response) {
                console.log('Estoque atualizado com sucesso:', response);
                $('#labelstock').text(response[0]);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error('Erro ao atualizar o estoque:', errorThrown);
                // Mostrar mensagem de erro ao usuário
                $('#error-message').text('Erro ao atualizar o estoque. Por favor, tente novamente mais tarde.');
            })
            .always(function () {
                // Código a ser executado independentemente do sucesso ou falha da solicitação
            });
        }
    });
 });
 