(function () {
"use strict";

angular.module('common')
.service('HrsadminService', HrsadminService)
.constant('ApiPath', 'http://localhost:8888/mgtime/public/ajax/');


HrsadminService.$inject = ['$http', 'ApiPath'];
function HrsadminService($http, ApiPath) {
  var service = this;



}



})();
