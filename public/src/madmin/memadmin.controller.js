(function () {
'use strict';

angular.module('MadminApp')
.controller('MemadminController',MemadminController);

MemadminController.$inject=['MemadminService', 'info', 'list'];
function MemadminController(MemadminService, info, list) {
  var mactrl=this;

  mactrl.list = list.data;
  mactrl.page = 1;
  mactrl.last = info.data.last;




}

})();
