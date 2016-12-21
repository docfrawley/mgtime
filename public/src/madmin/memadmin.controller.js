(function () {
'use strict';

angular.module('MadminApp')
.controller('MemadminController',MemadminController);

MemadminController.$inject=['MemadminService', 'info', 'list'];
function MemadminController(MemadminService, info, list) {
  var mactrl=this;
  mactrl.page = 1;
  mactrl.list = list.data;

  mactrl.last = info.data.last;
  mactrl.range = [];
  for(var i=1;i<=mactrl.last;i++) {
    mactrl.range.push(i);
  }

  mactrl.firstPage = function ()  {
    mactrl.page = 1;
  };

  mactrl.decreasePage = function ()  {
    if (mactrl.page>1){
      mactrl.page = parseInt(mactrl.page) - 1;
    } else {
      mactrl.page = 1;
    }
  };

  mactrl.increasePage = function ()  {
    if (mactrl.page < mactrl.last){
      mactrl.page = parseInt(mactrl.page) + 1;
    }
  };

  mactrl.lastPage = function ()  {
    mactrl.page = parseInt(mactrl.last);
  };

  mactrl.getNewPage = function(){
    MemadminService.getList(mactrl.page)
      .then(function (response){
        mactrl.list = response.data;
        console.log("nlist:", mactrl.page, mactrl.list);
      })
      .catch(function (error) {
        console.log(error);
      });
  };


}

})();
