<div class="filter">
  <label>&nbsp Filters: </label>
  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('deleted-items') != null)
        {{ request('deleted-items') }}
      @else
        Filter by Deleted Items
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('teacher-routine.index', $teacher->id) }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('routine-group') != null)
        {{ request('routine-group') }}
      @else
        Group
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('teacher-routine.index', $teacher->id) }}">
              All
            </a>
        </li>

        @foreach($routine_groups as $routine_group)
          <li>
            <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'filter_by' => 'routine-group', 'routine-group' => $routine_group->name ])) }}">
              {{ $routine_group->name }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('subject') != null)
        {{ request('subject') }}
      @else
        Subject
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('teacher-routine.index', $teacher->id) }}">
              All
            </a>
        </li>

        @foreach($subjects as $subject)
          <li>
            <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'filter_by' => 'subject', 'subject' => $subject ])) }}">
              {{ $subject }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>
</div>

<div class="row">
  <div class="range-filter col-md-6" style="margin-bottom: 8px;">
      <span class="filter-span">Date: </span>
      <form>
        <div class="input-group input-group-sm" style="width: 50%">
          <input type="text" name="routine_date" value="{{ request('routine_date') }}" class="form-control" id="custom-nepali-date" placeholder="Select Date">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>
          </div>
      </form>
  </div>

  <div class="range-filter col-md-6">
      <span class="filter-span">Date Range: </span>
      <form>
        <div class="input-group input-group-sm">

            <input type="text" name="from_routineDate" value="{{ request('from_routineDate') }}" class="form-control" id="from-nepali-date" placeholder="From Date"  style="width: 50%">

            <input type="text" name="till_routineDate" value="{{ request('till_routineDate') }}" class="form-control" id="to-nepali-date" placeholder="Till Date"  style="width: 50%">

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
              <a href="{{ route('teacher-routine.index', $teacher->id) }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('teacher-routine.index', array_merge(Request::all(), ['teacher_id' => $teacher->id, 'show-items' => $total_routine_class])) }}">
                All
              </a>
          </li>
      </ul>
    </li>
  </div>

  <div class="search">
   <form>
      <div class="input-group input-group-sm">
        <input type="text" name="search-item" value="{{ request('search-item') }}" class="form-control pull-right" placeholder="Search">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
  </div>
</div>