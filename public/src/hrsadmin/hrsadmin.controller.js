(function () {
'use strict';

angular.module('HadminApp')
.controller('HrsadminController', HrsadminController);

HrsadminController.$inject=['HrsadminService', 'list', 'rlist', 'nonlist'];
function HrsadminController(HrsadminService, list, rlist, nonlist) {
  var hactrl=this;

  hactrl.list = list.data;
  hactrl.rlist = rlist.data;
  hactrl.doWhat = 'regNoHrs';
  hactrl.nonlist = nonlist.data;



hactrl.changeLook = function(doWhat){
  hactrl.doWhat= doWhat;
}

}

})();
