(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsreportController', HrsreportController);

HrsreportController.$inject=['HrsadminService', 'list', 'rlist', 'nonlist'];
function HrsreportController(HrsadminService, list, rlist, nonlist) {
  var hrctrl=this;

  hrctrl.list = list.data;
  hrctrl.rlist = rlist.data;
  hrctrl.doWhat = 'regNoHrs';
  hrctrl.nonlist = nonlist.data;



hrctrl.changeLook = function(){
  hrctrl.doWhat= (hrctrl.doWhat=='regNoHrs')? 'notReg':'regNoHrs';
}

}

})();
