(function () {
'use strict';

angular.module('HadminApp')
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
    controller: 'HrsadminController',
    controllerAs: 'hactrl',
    templateUrl: 'src/hrsadmin/hoursadmin.php',
    resolve: {
      list: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.getList('full', 'full', 1);
      }],
      rlist: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.getRegList();
      }],
      nonlist: ['HrsadminService',function (HrsadminService) {
        return HrsadminService.getNonList();
      }]
    }
  });


}

})();
