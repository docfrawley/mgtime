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
            first-page    = "hmctrl.firstPage()"
            new-page      = "hmctrl.getNewPage()"
            decrease-page = "hmctrl.decreasePage()"
            increase-page = "hmctrl.increasePage()"
            last-page     = "hmctrl.lastPage()"
            option-page   = "hmctrl.optionPage(index)">
        </page-turn><br>
          <show-members
            list="hmctrl.list"
            got-memberid="hmctrl.whenGotId(index)"></show-members><br>
        <page-turn
            range         = "hmctrl.range"
            first-page    = "hmctrl.firstPage()"
            new-page      = "hmctrl.getNewPage()"
            decrease-page = "hmctrl.decreasePage()"
            increase-page = "hmctrl.increasePage()"
            last-page     = "hmctrl.lastPage()"
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
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-body">
          <h3 class="text-center">ANNUAL HOURS</h3><br>
          <h5 class="text-left">Edit or Delete Entries by clicking on date</h5><br>

          <page-turn
              range         = "hmctrl.range"
              first-page    = "hmctrl.firstPage()"
              new-page      = "hmctrl.getNewPage()"
              decrease-page = "hmctrl.decreasePage()"
              increase-page = "hmctrl.increasePage()"
              last-page     = "hmctrl.lastPage()"
              option-page   = "hmctrl.optionPage(index)">
          </page-turn>

          <show-hours
            list="hmctrl.meminfo.annual"></show-hours>
          <page-turn
              range         = "hmctrl.range"
              first-page    = "hmctrl.firstPage()"
              new-page      = "hmctrl.getNewPage()"
              decrease-page = "hmctrl.decreasePage()"
              increase-page = "hmctrl.increasePage()"
              last-page     = "hmctrl.lastPage()"
              option-page   = "hmctrl.optionPage(index)">
          </page-turn>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <show-totals
      list="hmctrl.meminfo"></show-totals>
</div>
