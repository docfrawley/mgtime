(function () {
"use strict";

angular.module('HadminApp')
.component('pageTurn', {
  templateUrl: 'src/hrsadmin/page-turn/page-turn.html',
  controller: pageturnComponentController,
  bindings: {
    range:        '<',
    newPage:      '&',
    optionPage:   '&'
  }
});


pageturnComponentController.$inject = ['$scope', '$element']
function pageturnComponentController($scope, $element) {
  var $ctrl = this;
  $ctrl.page = 1;
  $ctrl.last = $ctrl.range.length;
  console.log("hello:", $ctrl.last);
  $ctrl.opPage = function () {
    $ctrl.optionPage({ index: $ctrl.page });
  };

  $ctrl.nPage = function () {
    $ctrl.newPage({ index: $ctrl.page });
  };

  $ctrl.firstPage = function(){
    $ctrl.page = 1;
  };

  $ctrl.decreasePage = function ()  {
    if ($ctrl.page>1){
      $ctrl.page = parseInt($ctrl.page) - 1;
    } else {
      $ctrl.page = 1;
    }
  };

  $ctrl.increasePage = function ()  {
    if ($ctrl.page < $ctrl.last){
      $ctrl.page = parseInt($ctrl.page) + 1;
    }
  };

  $ctrl.lastPage = function ()  {
    $ctrl.page = parseInt($ctrl.last);
  };


}

})();
