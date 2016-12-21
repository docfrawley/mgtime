(function () {
'use strict';

angular.module('MadminApp')
.controller('MemadminController',MemadminController);

MemadminController.$inject=['MemadminService', 'info', 'list', 'flist', 'hlist'];
function MemadminController(MemadminService, info, list, flist, hlist) {
  var mactrl=this;
  mactrl.page = 1;
  mactrl.list = list.data;
  mactrl.fulladmin = flist.data;
  mactrl.hrsadmin = hlist.data;

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
      })
      .catch(function (error) {
        console.log(error);
      });
  };


}

})();
