(function () {
'use strict';

angular.module('MadminApp')
.config(RoutesConfig);

RoutesConfig.$inject = ['$stateProvider', '$urlRouterProvider'];
function RoutesConfig($stateProvider, $urlRouterProvider) {

  // Redirect to home page if no other URL matches
  $urlRouterProvider.otherwise('/');

  // *** Set up UI states ***
  $stateProvider

  // Home page
  .state('home', {
    url: '/',
    controller: 'MemadminController',
    controllerAs: 'mactrl',
    templateUrl: 'src/madmin/madmin.html',
    resolve: {
      info: ['MemadminService',function (MemadminService) {
        return MemadminService.getInitialInfo();
      }],
      list: ['MemadminService',function (MemadminService) {
        return MemadminService.getList(1);
      }]
    }
  });


}

})();
