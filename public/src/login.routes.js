(function () {
'use strict';

angular.module('LoginApp')
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
    controller: 'RegisterController',
    controllerAs: 'regctrl',
    templateUrl: 'src/login/initial/initial.html'
  })

  // Premade list page
  .state('register', {
    url: '/register',
    controller: 'RegisterController',
    controllerAs: 'regctrl',
    templateUrl: 'src/login/register/register.html'
  });

}

})();
