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
    templateUrl: 'src/hrsadmin/hoursadmin.php'
  });


}

})();
