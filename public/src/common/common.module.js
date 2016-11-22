(function() {
"use strict";

angular.module('common', [])
.constant('ApiPath', 'http://localhost:8888/mgtime/public/')
.config(config);

config.$inject = ['$httpProvider'];
function config($httpProvider) {
  $httpProvider.interceptors.push('loadingHttpInterceptor');
}

})();
