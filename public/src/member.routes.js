(function () {
'use strict';

angular.module('MemberApp')
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
    controller: 'MemberController',
    controllerAs: 'mctrl',
    templateUrl: 'src/member/member.html',
    resolve: {
      info: ['MemberService',function (MemberService) {
        return MemberService.getInfo();
      }]
    }
  });

}

})();
