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
            <a href="{{ route('routine-class-time.index', $routine_group->id) }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('routine-class-time.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('routine-class-time.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
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
              <a href="{{ route('routine-class-time.index', $routine_group->id) }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-class-time.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-class-time.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-class-time.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('routine-class-time.index', array_merge(Request::all(), ['group_id' => $routine_group->id, 'show-items' => $total_routine_class_time])) }}">
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