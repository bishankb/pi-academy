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
            <a href="{{ route('examination-results.student-list') }}">
              Without Deleted
            </a>
        </li>
        <li>
          <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted'])) }}">
            Only Deleted
          </a>
        </li>
        <li>
          <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['filter_by' => 'deleted-items', 'deleted-items' => 'All'])) }}">
            All
          </a>
        </li>
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('gender') != null)
        {{ request('gender') }}
      @else
        Gender
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('examination-results.student-list') }}">
              All
            </a>
        </li>
        @foreach(\App\ScholarshipTest::Gender as $gender)
          <li>
            <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['filter_by' => 'gender', 'gender' => $gender ])) }}">
              {{ $gender }}
            </a>
          </li>
        @endforeach
    </ul>
  </li>

  <li class="dropdown dropdown-inline">
    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
      @if(request('education-level') != null)
        {{ request('education-level') }}
      @else
        Education Level
      @endif
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('examination-results.student-list') }}">
              All
            </a>
        </li>

        @foreach($education_levels as $education_level)
          <li>
            <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['filter_by' => 'education-level', 'education-level' => $education_level ])) }}">
              {{ $education_level }}
            </a>
          </li>
        @endforeach
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
            <a href="{{ route('examination-results.student-list') }}">
              All
            </a>
        </li>

        @foreach($interested_courses as $interested_course)
          <li>
            <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['filter_by' => 'interested-course', 'interested-course' => $interested_course ])) }}">
              {{ $interested_course }}
            </a>
          </li>
        @endforeach
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
            <a href="{{ route('examination-results.student-list') }}">
              All
            </a>
        </li>
        @foreach(\App\ScholarshipTest::Shift as $shift)
          <li>
            <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['filter_by' => 'shift', 'shift' => $shift ])) }}">
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
              <a href="{{ route('examination-results.student-list') }}">
                10 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['show-items' => 25])) }}">
                25 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['show-items' => 50])) }}">
                50 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['show-items' => 100])) }}">
                100 records
              </a>
          </li>
          <li>
              <a href="{{ route('examination-results.student-list', array_merge(Request::all(), ['show-items' =>  $total_student])) }}">
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
