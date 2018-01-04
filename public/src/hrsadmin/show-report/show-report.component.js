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
    rangeChange:  '&',
    year:         '<'
  }
});

srController.$inject = ['HrsadminService','$scope', '$element']
function srController(HrsadminService, $scope, $element) {
  var $ctrl = this;

  $ctrl.page = 1;
  $ctrl.listLength = $ctrl.list.length;

  // var d = new Date();
  // $ctrl.year = d.getFullYear();
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
    case 'endlist':
        $ctrl.wreport = "End of Year Report"
      break;
    default:
      break;
  };

  if ($ctrl.last.type !=='number'){
    switch ($ctrl.last) {
      case 'l100':
        $ctrl.mRange = 'With Less Than 100hrs'
        break;
      case 'l250':
          $ctrl.mRange = "Between 100 and 250hrs"
        break;
      case 'l500':
          $ctrl.mRange = "Between 250 and 500hrs"
        break;
      case 'l1000':
          $ctrl.mRange = "Between 500 and 1000hrs"
        break;
      case 'l2500':
          $ctrl.mRange = "Between 1000 and 2500hrs"
        break;
      case 'l5000':
          $ctrl.mRange = "Between 2500 and 5000hrs"
        break;
      case '5000+':
          $ctrl.mRange = "With 5000 or More Hours"
        break;
      case 'A - Trainee':
          $ctrl.mRange = "Active Trainees"
        break;
      case 'A':
          $ctrl.mRange = "Active Members"
        break;
      case 'Active 1000hrs':
          $ctrl.mRange = "Active Members, 1000hrs"
        break;
      default:
        break;

    }
  }

  $ctrl.rdpage = "";
  $ctrl.opPage = function(){
    $ctrl.newRange($ctrl.rdpage);
  }

  $ctrl.newRange = function (theindex) {
    $ctrl.rangeChange({ index: theindex });
  };

  $ctrl.range = [];
  for(var i=1;i<=$ctrl.last;i++) {
    $ctrl.range.push(i);
  };

  $ctrl.getNewPage = function(theindex) {
    $ctrl.page = theindex;
    HrsadminService.rList($ctrl.whichreport, $ctrl.page)
      .then(function (response){
        $ctrl.list = response.data.reportArray;
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  $ctrl.optionPage = function(theindex) {
    var tindex = parseInt(theindex);
    $ctrl.getNewPage(tindex);
  };


}

})();
