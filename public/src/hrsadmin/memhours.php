<div class="row">
  <div class="col-sm-12 text-center">
    <h1>Hours Administration: Member Hours</h1>
  </div>
  <div class="col-sm-12 text-center">
    <button ui-sref="reports" class='btn btn-sm btn-info'>REPORTS</button>
    <button ui-sref="home" class='btn btn-sm btn-info'>ONLINE REG</button>
  </div>
</div><br>

<div class="row" ng-if="!hmctrl.lookAtMember">
    <div class="col-md-3"><br><br>
      <search-member
        got-memberid="hmctrl.whenGotId(index)"></search-member>
    </div>
    <div class="col-md-9" >
      <div class="row">
        <div class="col-sm-12 text-center">
          <h2>Full Member Hours</h2>
        </div><br>
        <page-turn
            range         = "hmctrl.range"
            new-page      = "hmctrl.getNewPage(index)"
            option-page   = "hmctrl.optionPage(index)">
        </page-turn><br>
          <show-members
            list="hmctrl.list"
            got-memberid="hmctrl.whenGotId(index)"></show-members><br>
        <page-turn
            range         = "hmctrl.range"
            new-page      = "hmctrl.getNewPage(index)"
            option-page   = "hmctrl.optionPage(index)">
        </page-turn>
      </div>
    </div>
</div>

<div class="row" ng-if="hmctrl.lookAtMember"><br>
  <div class= "row">
    <div class="col-sm-5 text-left">
      <h3>Time Collection for {{hmctrl.meminfo.minfo.name}}</h3>
    </div>
    <div class="col-sm-7 text-left">
      <button class='btn btn-sm btn-info' ng-click="hmctrl.memberLists()">BACK TO MEMBERS LIST</button>
    </div>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="panel panel-default">
        <div class="panel-body">
          <h3 class="text-center">ANNUAL HOURS</h3><br>
          <h5 class="text-left">Edit or Delete Entries by clicking on date</h5><br>
          <div ng-show="hmctrl.trange.length>1">
            <page-turn
                range         = "hmctrl.trange"
                new-page      = "hmctrl.getNewHPage(index)"
                option-page   = "hmctrl.optionHPage(index)">
            </page-turn>
          </div>

          <show-hours
              list      = "hmctrl.meminfo.annual"
              do-edit   = "hmctrl.doEdit(index)"
              do-delete = "hmctrl.doDelete(index)"></show-hours>

          <div ng-show="hmctrl.trange.length>1">
            <page-turn
                range         = "hmctrl.trange"
                new-page      = "hmctrl.getNewHPage(index)"
                option-page   = "hmctrl.optionHPage(index)">
            </page-turn>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <show-totals
      list="hmctrl.meminfo"></show-totals>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Entry for {{hmctrl.edItems.hdate}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class=row>
          <div ng-if="hmctrl.madeUpdates" class="alert alert-success" role="alert">
            Updates have been made in the system</div>
          <label class="col-sm-2 control-label text-left"
          for="inputEmail">Type Hrs: </label>
          <div class="col-sm-4">
            <select class="custom-select form-control"
                    ng-model="hmctrl.items.hrstype">
              <option value="Mercer County">Mercer County</option>
              <option value="Helpline">Helpline</option>
              <option ng-show="hmctrl.mgstatus!='A - Trainee'"
                      value="Continuing Ed">Continuing Ed</option>
              <option ng-show="hmctrl.mgstatus=='A - Trainee'"
                      value="Compost (Trainee)">Compost (Trainee)</option>
            </select>
         </div>


          <label class="col-sm-2 control-label text-right"
          for="inputEmail"> # of Hrs: </label>
          <div class="col-sm-4">
            <input class="form-control" type="text"
             placeholder={{hmctrl.edItems.numhrs}}
             ng-model="hmctrl.items.numhrs">
         </div><br />
       </div><br />
       <div class="row">
          <label class="col-sm-2 control-label text-left"
          for="inputEmail">Description: </label>
          <div class="col-sm-10">
            <input class="form-control" type="text" name="description"
             placeholder={{hmctrl.edItems.description}}
             ng-model="hmctrl.items.description">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" ng-click="hmctrl.makeUpdate()">UPDATE</button>
      </div>
    </div>
  </div>
</div>
