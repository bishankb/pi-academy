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
            <a href="{{ route('visitors.index') }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('visitors.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('visitors.index', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('academic-status') != null)
        {{ request('academic-status') }}
      @else
        Academic Status
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('visitors.index') }}">
              All
            </a>
        </li>

        @foreach(\App\Visitor::AcademicStatus as $academic_status)
          <li>
            <a href="{{ route('visitors.index', array_merge(Request::all(), ['filter_by' => 'academic-status', 'academic-status' => $academic_status ])) }}">
              {{ $academic_status }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('register-status') != null)
        {{ request('register-status') }}
      @else
        Register Status
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('visitors.index') }}">
              All
            </a>
        </li>

        <li>
            <a href="{{ route('visitors.index', array_merge(Request::all(), ['filter_by' => 'register-status', 'register-status' => 'Registered'])) }}">
              Registered
            </a>
        </li>

        <li>
          <a href="{{ route('visitors.index', array_merge(Request::all(), ['filter_by' => 'register-status', 'register-status' => 'Not Registered'])) }}">
            Not Registered
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('interested-course') != null)
        {{ request('interested-course') }}
      @else
        Interested Course
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('visitors.index') }}">
              All
            </a>
        </li>

        @foreach($interested_courses as $interested_course)
          <li>
            <a href="{{ route('visitors.index', array_merge(Request::all(), ['filter_by' => 'interested-course', 'interested-course' => $interested_course ])) }}">
              {{ $interested_course }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>
</div>

<div class="row">
  <div class="range-filter col-md-6">
      <span class="filter-span">Nepali Date: </span>
      <form>
        <div class="input-group input-group-sm">

            <input type="text" name="from_visitedPeriod" value="{{ request('from_visitedPeriod') }}" class="form-control" id="from-nepali-date" placeholder="From Date"  style="width: 50%">

            <input type="text" name="till_visitedPeriod" value="{{ request('till_visitedPeriod') }}" class="form-control" id="to-nepali-date" placeholder="Till Date"  style="width: 50%">

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
              <a href="{{ route('visitors.index') }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('visitors.index', array_merge(Request::all(), ['show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('visitors.index', array_merge(Request::all(), ['show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('visitors.index', array_merge(Request::all(), ['show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('visitors.index', array_merge(Request::all(), ['show-items' =>  $total_visitor])) }}">
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
