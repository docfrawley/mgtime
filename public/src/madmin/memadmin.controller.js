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
  mactrl.deleted = false;
  mactrl.filterOn = false;
  mactrl.makeAllChecked=false;
  mactrl.checkedArray=[];

  mactrl.page = 1;
  mactrl.filter='full';
  mactrl.filterwhich='full';
  mactrl.list = list.data;

  mactrl.fulladmin = flist.data;
  mactrl.hrsadmin = hlist.data;

  mactrl.last = info.data.last;
  mactrl.classRange = [];
  var thisYear = new Date().getFullYear();
  for (var x=info.data.firstyear; x<= thisYear;x++){
    mactrl.classRange.push(x);
  }
  mactrl.range = [];
  for(var i=1;i<=mactrl.last;i++) {
    mactrl.range.push(i);
  }

  mactrl.checkall = function() {
    if (mactrl.checkedArray.length == mactrl.list.length){
      mactrl.checkedArray = [];
      mactrl.makeAllChecked= false;
    } else {
      mactrl.makeAllChecked= true;
      for(let i=0; i<mactrl.list.length; i++){
        mactrl.checkedArray[i]=mactrl.list[i].id;
      }

    }

    console.log('checkedArray: ', mactrl.checkedArray);
  };

  mactrl.changeChecked = function (){
    console.log("what I got: ", mactrl.checkedArray);
  };

  mactrl.changeInList = function(id){
    var theIndex = mactrl.checkedArray.indexOf(id);
    if (theIndex>-1){
      mactrl.checkedArray.splice(theIndex,1);
    } else {
      mactrl.checkedArray.push(id);
    }
    console.log("checkedArray:", mactrl.checkedArray);
  };

  mactrl.showFilter= function () {
    mactrl.filterOn = true;
  };

  mactrl.backToFull = function(){
    mactrl.filterOn=false;
    mactrl.filter='full';
    mactrl.filterwhich='full';
    mactrl.Mgstatus = '';
    mactrl.getYear = '';
    mactrl.page=1;
    mactrl.getNewPage();
    mactrl.getNewLast();
  }

  mactrl.getClassYear = function () {
    mactrl.filter='class';
    mactrl.filterwhich=mactrl.getYear;
    mactrl.Mgstatus = '';
    mactrl.page=1;
    mactrl.getNewPage();
    mactrl.getNewLast();
  };

  mactrl.getMgstatus = function(){
    mactrl.filter='mgstatus';
    mactrl.getYear = "";
    mactrl.filterwhich=mactrl.Mgstatus;
    mactrl.page=1;
    mactrl.getNewPage();
    mactrl.getNewLast();
  };

  mactrl.getFull = function(){
    mactrl.filter='full';
    mactrl.filterwhich='full';
    mactrl.page=1;
    mactrl.getNewPage();
    mactrl.getNewLast();
  };

  mactrl.getNewLast = function () {
    MemadminService.getLast(mactrl.filter, mactrl.filterwhich)
      .then(function (response){
        mactrl.last = response.data.last;
        mactrl.range = [];
        for(var i=1;i<=mactrl.last;i++) {
          mactrl.range.push(i);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
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
    MemadminService.getList(mactrl.filter, mactrl.filterwhich, mactrl.page)
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
        if (mactrl.search_items.length == 0){
          mactrl.found = false;
        } else if (mactrl.search_items.length>1) {
          mactrl.found_list = response.data;
          mactrl.found=true;
          mactrl.not_multiple = false;
        } else {
          mactrl.addhrs = false;
          mactrl.did_search = false;
          mactrl.not_multiple = true;
          mactrl.search_lname = "";
          mactrl.edItems = response.data[0];
        }

      })
      .catch(function (error) {
        console.log(error);
      });
  };

  mactrl.asubmit = function(addForm){
    MemadminService.addMember(mactrl.fname, mactrl.lname, mactrl.class,
      mactrl.mgstatus, mactrl.admin_status)
      .then(function (response){
        mactrl.fname = "";
        mactrl.lname = "";
        mactrl.class = "";
        mactrl.mgstatus = "";
        mactrl.admin_status = "";
        mactrl.added = true;
        addForm.$setUntouched();
      })
      .then(function (response) {
        MemadminService.getList(mactrl.page)
        .then(function (response) {
        mactrl.list = response.data;
      });
      })
      .then(function (response) {
        MemadminService.getInitialInfo()
        .then(function (response) {
        mactrl.last = response.data.last;
      });
      })
      .then(function (response) {
        MemadminService.getFList()
        .then(function (response) {
          mactrl.fulladmin = response.data;
      });
      })
      .then(function (response) {
        MemadminService.getHList()
        .then(function (response) {
        mactrl.hrsadmin = response.data;
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  mactrl.dprepare = function (){
    if (confirm("Are you sure you want to delete this member?") == true) {
        mactrl.dsubmit();
    }
  };

  mactrl.dsubmit = function(){
    MemadminService.deleteMember(mactrl.edItems.id)
      .then(function (response){
        mactrl.deleted = true;
        mactrl.addhrs = true;
        mactrl.added = false;
      })
      .then(function (response) {
        MemadminService.getList(mactrl.page)
        .then(function (response) {
        mactrl.list = response.data;
      });
      })
      .then(function (response) {
        MemadminService.getInitialInfo()
        .then(function (response) {
        mactrl.last = response.data.last;
      });
      })
      .then(function (response) {
        MemadminService.getFList()
        .then(function (response) {
          mactrl.fulladmin = response.data;
      });
      })
      .then(function (response) {
        MemadminService.getHList()
        .then(function (response) {
        mactrl.hrsadmin = response.data;
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  mactrl.esubmit = function(){
    MemadminService.editMember(mactrl.edItems)
      .then(function (response){
        mactrl.edited = true;
        mactrl.added = false;
        console.log("response: ", response.data);
      })
      .then(function (response) {
        MemadminService.getList(mactrl.page)
        .then(function (response) {
        mactrl.list = response.data;
      });
      })
      .then(function (response) {
        MemadminService.getInitialInfo()
        .then(function (response) {
        mactrl.last = response.data.last;
      });
      })
      .then(function (response) {
        MemadminService.getFList()
        .then(function (response) {
          mactrl.fulladmin = response.data;
      });
      })
      .then(function (response) {
        MemadminService.getHList()
        .then(function (response) {
        mactrl.hrsadmin = response.data;
      });
      })
      .catch(function (error) {
        console.log(error);
      });
  };

  mactrl.backToAdd = function ()  {
    mactrl.added = false;
    mactrl.addhrs = true;
    mactrl.edited = false;
    mactrl.deleted = false;
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
    mactrl.did_search = false;
    mactrl.not_multiple = true;
    mactrl.search_lname = "";
    mactrl.edItems = mactrl.found_list[index];
  };

}

})();
