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
            <a href="{{ route('routine-groups.index') }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('shift') != null)
        {{ request('shift') }}
      @else
        Shift
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('routine-groups.index') }}">
              All
            </a>
        </li>
        @foreach($shifts as $shift)
          <li>
            <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['filter_by' => 'shift', 'shift' => $shift ])) }}">
              {{ $shift }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>
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
              <a href="{{ route('routine-groups.index') }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-groups.index', array_merge(Request::all(), ['show-items' => $total_routine_group])) }}">
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