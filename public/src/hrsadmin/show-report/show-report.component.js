(function () {
"use strict";

angular.module('HadminApp')
.component('showReport', {
  templateUrl: 'src/hrsadmin/show-report/show-report.html',
  controller: srController,
  bindings: {
    list:         '<',
    whichreport:  '<',
    last:         '<',
    getNew:       '&',
    getOption:    '&'
  }
});

srController.$inject = ['HrsadminService','$scope', '$element']
function srController(HrsadminService, $scope, $element) {
  var $ctrl = this;
  switch ($ctrl.whichreport) {
    case 'nclist':
        $ctrl.wreport = "New Class Report"
      break;
    case 'mlist':
        $ctrl.wreport = "Milestones Report"
      break;
    case 'slist':
        $ctrl.wreport = "Summary Report"
      break;
    case 'rdlist':
        $ctrl.wreport = "Requirement Deficiencies Report"
      break;
    default:
      break;
  };

  $ctrl.range = [];
  for(var i=1;i<=$ctrl.last;i++) {
    $ctrl.range.push(i);
  };

  $ctrl.getNewPage = function(theindex) {
    $ctrl.getNew({ index: theindex });
  };

  $ctrl.optionPage = function(theindex) {
    var tindex = parseInt(theindex);
    $ctrl.getOption({ index: tindex });
  };


}

})();
