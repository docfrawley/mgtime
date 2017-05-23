<div class="row">
  <div class="col-sm-12 text-center">
    <h1>Hours Administration: Member Hours</h1>
  </div>
  <!-- <div class="col-sm-12 text-center">
    <button ui-sref="reports" class='btn btn-sm btn-info'>REPORTS</button>
    <button ui-sref="home" class='btn btn-sm btn-info'>ONLINE REG</button>
  </div> -->
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
              do-delete = "hmctrl.doDelete(index)"
              do-undo   = "hmctrl.doUndo(index)"></show-hours>

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
      <div class="row">
        <div class="col-sm-12">
          <show-totals
          list="hmctrl.meminfo"></show-totals>
        </div>

      </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div ng-if="hmctrl.goEditModul">
        <modal-edit
          list="hmctrl.items"
          made-updates = "hmctrl.madeUpdates"
          make-update = "hmctrl.makeUpdate(index)"></modal-edit>
      </div>
      <div ng-if="hmctrl.goDeleteModul">
        <modal-delete
          made-delete = "hmctrl.madeDelete"
          make-delete = "hmctrl.makeDelete(index)"></modal-delete>
      </div>
      <div ng-if="hmctrl.goUndoModul">
        <modal-undo
          now="hmctrl.undoItem"
          changes="hmctrl.changes"
          made-undo = "hmctrl.madeUndo"
          make-undo = "hmctrl.makeUndo()"></modal-undo>
      </div>
    </div>
  </div>
</div>
