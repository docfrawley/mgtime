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
  console.log("last", mactrl.last);

  mactrl.firstPage = function ()  {
    mactrl.page = 1;
    console.log("first", mactrl.page);
  };

  mactrl.decreasePage = function ()  {
    if (mactrl.page>1){
      mactrl.page = parseInt(mactrl.page) - 1;
    } else {
      mactrl.page = 1;
    }
    console.log("decrease", mactrl.page);
  };

  mactrl.increasePage = function ()  {
    if (mactrl.page < mactrl.last){
      mactrl.page = parseInt(mactrl.page) + 1;
      console.log("increase", mactrl.page);
    }
  };

  mactrl.lastPage = function ()  {
    mactrl.page = parseInt(mactrl.last);
    console.log("last", mactrl.page);
  };

  mactrl.getNewPage = function(){
    MemadminService.getList(mactrl.page)
      .then(function (response){
        mactrl.list = response.data;
        console.log("nlist", mactrl.list);
      })
      .catch(function (error) {
        console.log(error);
      });
  };


}

})();
