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
            <a href="{{ route('attendence.staff-list') }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('role') != null)
        {{ request('role') }}
      @else
        Filter by Roles
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('attendence.staff-list') }}">
              All
            </a>
        </li>
        @foreach($roles as $role)
          <li>
            <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['filter_by' => 'role', 'role' => $role->name ])) }}">
              {{ $role->display_name }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>
</div>

<div class="row">
  <div class="range-filter col-md-6">
      <span class="filter-span">Attendence Status of: </span>
      <form>
        <div class="input-group input-group-sm" style="width: 50%">
          <input type="text" name="select_date" value="{{ request('select_date') ? request('select_date') : $current_nepali_date }}" class="form-control" id="custom-nepali-date" placeholder="Select Date">
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
              <a href="{{ route('attendence.staff-list') }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('attendence.staff-list', array_merge(Request::all(), ['show-items' => $total_staff])) }}">
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