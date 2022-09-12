<div class="col-lg-3 col-md-12 col-sm-12 blog-main-sidebar fw-sidebar">
  <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
    <h6>Recent Fund Watch</h6>
    @if(count($rcntDataListModel) > 0)
    <ul class="reset">
      @foreach($rcntDataListModel as $key => $record2)
      <li>
        <a href="{{ route('web.fundwatch', $record2['fw_id']) }}" {{ ($reqId == $record2['fw_id'])?'class=active':'' }}>{{ $record2['title'] }}</a>
      </li>
      @endforeach
    </ul>
    @endif
  </div>

  <div class="blog-sidebar-links blog-sidebar-block bg-gry br-5 box-shadow">
    <h6>Archives</h6>
    @if(count($archiveListModel) > 0)
    <ul class="reset">
      @foreach($archiveListModel as $key => $record3)
      <li>
        <a href="{{ route('web.fundwatch.list', $record3['year']) }}" {{ ($reqYear == $record3['year'])?'class=active':'' }}>{{ $record3['year'] }} <span>({{ $record3['tot'] }})</span></a>
      </li>
      @endforeach
    </ul>
    @endif
  </div>
</div>