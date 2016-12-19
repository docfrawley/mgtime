(function () {
'use strict';

angular.module('MadminApp')
.controller('MemadminController',MemadminController);

MemadminController.$inject=['MemadminService', 'info', 'list'];
function MemadminController(MemadminService, info, list) {
  var mactrl=this;
  console.log("hello");
  mactrl.page = 1;
  mactrl.list = list.data;

  mactrl.last = info.data.last;




}

})();
