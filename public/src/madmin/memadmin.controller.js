(function () {
'use strict';

angular.module('MadminApp')
.controller('MemadminController',MemadminController);

MemadminController.$inject=['MemadminService', 'info', 'list', 'flist', 'hlist'];
function MemadminController(MemadminService, info, list, flist, hlist) {
  var mactrl=this;

  mactrl.fname = "";
  mactrl.lname = "";
  mactrl.class = "";
  mactrl.mgstatus = "";
  mactrl.admin_status = "";
  mactrl.added = false;
  mactrl.addhrs = true;
  mactrl.edited = false;
  mactrl.search_lname = "";
  mactrl.did_search = false;
  mactrl.not_multiple = true;

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

  mactrl.goLook = function(){
    MemadminService.lookMember(mactrl.search_lname)
      .then(function (response){
        mactrl.search_items = response.data;
        mactrl.did_search = true;
        if (mactrl.search_items == 0){
          mactrl.found = false;
        } else if (mactrl.search_items>1) {
          mactrl.found_list = response.data;
          mactrl.found=true;
          mactrl.not_multiple = false;
        } else {
          mactrl.search_lname="";
          mactrl.edItems = response.data;
        }

        console.log("response: ", response.data);
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  mactrl.asubmit = function(){
    MemadminService.addMember(mactrl.fname, mactrl.lname, mactrl.class,
      mactrl.mgstatus, mactrl.admin_status)
      .then(function (response){
        mactrl.fname = "";
        mactrl.lname = "";
        mactrl.class = "";
        mactrl.mgstatus = "";
        mactrl.admin_status = "";
        mactrl.added = true;

        console.log("response: ", response.data);
      })
      .then(function (response) {
        MemadminService.getList(mactrl.page)
        .then(function (response) {
        mactrl.list = response.data;
        console.log("response: ", response.data);
      });
      })
      .then(function (response) {
        MemadminService.getInitialInfo()
        .then(function (response) {
        mactrl.last = response.data.last;
        console.log("response: ", response.data);
      });
      })
      .then(function (response) {
        MemadminService.getFList()
        .then(function (response) {
          mactrl.fulladmin = response.data;
          console.log("response: ", response.data);
      });
      })
      .then(function (response) {
        MemadminService.getHList()
        .then(function (response) {
        mactrl.hrsadmin = response.data;
        console.log("response: ", response.data);
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  mactrl.esubmit = function(){
    MemadminService.addMember(mactrl.edItems.id, mactrl.edItems.class,
      mactrl.edItems.mgstatus, mactrl.edItems.admin_status)
      .then(function (response){
        mactrl.edited = true;
        console.log("response: ", response.data);
      })
      .then(function (response) {
        MemadminService.getList(mactrl.page)
        .then(function (response) {
        mactrl.list = response.data;
        console.log("response: ", response.data);
      });
      })
      .then(function (response) {
        MemadminService.getInitialInfo()
        .then(function (response) {
        mactrl.last = response.data.last;
        console.log("response: ", response.data);
      });
      })
      .then(function (response) {
        MemadminService.getFList()
        .then(function (response) {
          mactrl.fulladmin = response.data;
          console.log("response: ", response.data);
      });
      })
      .then(function (response) {
        MemadminService.getHList()
        .then(function (response) {
        mactrl.hrsadmin = response.data;
        console.log("response: ", response.data);
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  mactrl.backToAdd = function ()  {
    mactrl.added = false;
    mactrl.addhrs = true;
  };

  mactrl.gomodul = function (index)  {
    mactrl.addhrs = false;
    mactrl.edItems = mactrl.list[index];
  };

  mactrl.gomodulf = function (index)  {
    mactrl.addhrs = false;
    mactrl.edItems = mactrl.fulladmin[index];
  };

  mactrl.gomodulh = function (index)  {
    mactrl.addhrs = false;
    mactrl.edItems = mactrl.hrsadmin[index];
  };

  mactrl.gomodull = function (index)  {
    mactrl.addhrs = false;
    mactrl.edItems = mactrl.found_list[index];
  };

}

})();
