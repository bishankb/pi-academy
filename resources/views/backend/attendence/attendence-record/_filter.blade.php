<div class="filter">
  <label>&nbsp Filters: </label>
  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" status="button" data-toggle="dropdown">
      @if(request('deleted-items') != null)
        {{ request('deleted-items') }}
      @else
        Filter by Deleted Items
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('attendence.index', $staff->id) }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('attendence-status') != null)
        {{ request('attendence-status') }}
      @else
        Attendence Status
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('attendence.index', $staff->id) }}">
              All
            </a>
        </li>
        <li>
          <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'filter_by' => 'attendence-status', 'attendence-status' => 'Present'])) }}">
            Present
          </a>
        </li>
        <li>
          <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'filter_by' => 'attendence-status', 'attendence-status' => 'On Leave'])) }}">
            On Leave
          </a>
        </li>
        <li>
          <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'filter_by' => 'attendence-status', 'attendence-status' => 'On Holiday'])) }}">
            On Holiday
          </a>
        </li>
    </ul>
  </li>
</div>

<div class="row">
  <div class="range-filter col-md-6">
      <span class="filter-span">Nepali Date: </span>
      <form>
        <div class="input-group input-group-sm">

            <input type="text" name="from_attendenceDate" value="{{ request('from_attendenceDate') }}" class="form-control" id="from-nepali-date" placeholder="From Date"  style="width: 50%">

            <input type="text" name="till_attendenceDate" value="{{ request('till_attendenceDate') }}" class="form-control" id="to-nepali-date" placeholder="Till Date"  style="width: 50%">

            <span class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
      </form>
  </div>
</div>

<div class="show-search">
  <div class="show-records">
    <li class="dropdown dropdown-inline">
      <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
        @if(request('show-items') != null)
          {{ request('show-items') }}
        @else
          10
        @endif
        <span class="caret"></span>
      </button>
      records
      <ul class="dropdown-menu">
          <li>
              <a href="{{ route('attendence.index', $staff->id) }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.index', array_merge(Request::all(), ['staff_id' => $staff->id, 'show-items' => $total_attendence])) }}">
                All
              </a>
          </li>
      </ul>
    </li>
  </div>
</div>