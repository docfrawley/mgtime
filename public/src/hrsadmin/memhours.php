<div class="row">
  <div class="col-sm-12 text-center">
    <h1>Hours Administration: Member Hours</h1>
  </div>
  <div class="col-sm-12 text-center">
    <button ui-sref="reports" class='btn btn-sm btn-info'>REPORTS</button>
    <button ui-sref="home" class='btn btn-sm btn-info'>ONLINE REG</button>
  </div>
</div><br>


<page-turn
    range         = "hmctrl.range"
    first-page    = "hmctrl.firstPage()"
    new-page      = "hmctrl.getNewPage()"
    decrease-page = "hmctrl.decreasePage()"
    increase-page = "hmctrl.increasePage()"
    last-page     = "hmctrl.lastPage()"
    option-page   = "hmctrl.optionPage(index)">
</page-turn>
