<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>

      <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a href="{{ route('backend.dashboard') }}" class="nav-link nav-toggle">
          <i class="fa fa-tachometer"></i>
          <span class="title">Dashboard</span>
        </a>
      </li>

      @can('view_transactions')
        <li class="nav-item {{ Request::is('admin/transactions*') ? 'active' : '' }}">
          <a href="{{ route('transactions.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-money"></i>
            <span class="title">Transactions</span>
          </a>
        </li>
      @endcan

      @can('view_scholarship_tests')
        <li class="nav-item {{ Request::is('admin/scholarship-test*') ? 'active' : '' }}">
          <a href="{{ route('scholarship-test.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-graduation-cap"></i>
            <span class="title">Scholarship Test</span>
          </a>
        </li>
      @endcan

      @can('view_visitors')
        <li class="nav-item {{ Request::is('admin/visitors*') ? 'active' : '' }}">
          <a href="{{ route('visitors.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-users"></i>
            <span class="title">Visitor</span>
          </a>
        </li>
      @endcan

      @if(auth()->user()->can('view_student_registrations') || auth()->user()->can('view_examination_results'))
        <li class="nav-item {{ Request::is('admin/student-registration*') || Request::is('admin/student-list*') ? 'start active open' : '' }}">
          <a href="#" class="nav-link nav-toggle">
            <i class="fa fa-users"></i>
            <span class="title">Students</span>
            <span class="arrow"></span>
          </a>
          
          <ul class="sub-menu">
            @can('view_student_registrations')
              <li class="nav-item {{ Request::is('admin/student-registration*') ? 'active' : '' }}">
                <a href="{{ route('student-registration.index') }}" class="nav-link nav-toggle">
                  <i class="fa fa-list-alt"></i>
                  <span class="title">Student Registration</span>
                </a>
              </li>
            @endcan
            @can('view_examination_results')
              <li class="nav-item {{ Request::is('admin/student-list*') ? 'active' : '' }}">
                <a href="{{ route('examination-results.student-list')}}" class="nav-link ">
                  <i class="fa fa-database"></i>
                  <span class="title">Examination Result</span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endif

      @can('view_clients')
        <li class="nav-item {{ Request::is('admin/clients*') ? 'active' : '' }}">
          <a href="{{ route('clients.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-user"></i>
            <span class="title">Clients</span>
          </a>
        </li>
      @endcan

      @can('view_staff_attendences')
        <li class="nav-item {{ Request::is('admin/staff-list*') ? 'active' : '' }}">
          <a href="{{ route('attendence.staff-list') }}" class="nav-link nav-toggle">
            <i class="fa fa-calendar"></i>
            <span class="title">Attendence</span>
          </a>
        </li>
      @endcan

      @if(auth()->user()->can('view_question_sets') || auth()->user()->can('view_examination_questions'))
        @php
          $selectedSet = request('set_type');
        @endphp
        <li class="nav-item {{ Request::is('admin/question-sets*') || Request::is('admin/'.$selectedSet.'/examination-questions*') ? 'start active open' : '' }}">
          <a href="#" class="nav-link nav-toggle">
            <i class="fa fa-question-circle"></i>
            <span class="title">Examination Questions</span>
            <span class="arrow"></span>
          </a>
          
          <ul class="sub-menu">
            @can('view_question_sets')
              <li class="nav-item {{ Request::is('admin/question-sets*') ? 'active' : '' }}">
                <a href="{{ route('question-sets.index') }}" class="nav-link nav-toggle">
                  <i class="fa fa-list-alt"></i>
                  <span class="title">Question Set</span>
                </a>
              </li>
            @endcan
            @can('view_examination_questions')
              @if(count($question_sets) > 0)
                @foreach($question_sets as $question_set)
                  <li class="nav-item @if($question_set->slug == request('set_type')) active @endif">
                    <a href="{{ route('examination-questions.index', $question_set->slug)}}" class="nav-link ">
                      {{ $loop->iteration}})&nbsp;&nbsp;<span class="title">{{ $question_set->name }}</span>
                    </a>
                  </li>
                @endforeach
              @endif
            @endcan
          </ul>
        </li>
      @endif

      @if(auth()->user()->can('view_routine_groups') || auth()->user()->can('view_teacher_routines'))
        <li class="nav-item {{ Request::is('admin/routine-groups*') || Request::is('admin/teacher-list*') ? 'start active open' : '' }}">
          <a href="#" class="nav-link nav-toggle">
            <i class="fa fa-calendar-o"></i>
            <span class="title">Routine</span>
            <span class="arrow"></span>
          </a>
          
          <ul class="sub-menu">
            @can('view_routine_groups')
              <li class="nav-item {{ Request::is('admin/routine-groups*') ? 'active' : '' }}">
                <a href="{{ route('routine-groups.index') }}" class="nav-link nav-toggle">
                  <i class="fa fa-list-alt"></i>
                  <span class="title">Routine</span>
                </a>
              </li>
            @endcan
            @can('view_teacher_routines')
              <li class="nav-item {{ Request::is('admin/teacher-list*') ? 'active' : '' }}">
                <a href="{{ route('routine.teacher-list') }}" class="nav-link nav-toggle">
                  <i class="fa fa-calendar"></i>
                  <span class="title">Teacher Routines</span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endif

      @can('view_meetings')
        <li class="nav-item {{ Request::is('admin/meeting*') ? 'active' : '' }}">
          <a href="{{ route('meeting.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-users"></i>
            <span class="title">Meeting</span>
          </a>
        </li>
      @endcan
      
      @can('view_users')
        <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
          <a href="{{ route('users.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-user"></i>
            <span class="title">User</span>
          </a>
        </li>
      @endcan

      @can('view_roles')
        <li class="nav-item {{ Request::is('admin/roles*') ? 'active' : '' }}">
          <a href="{{ route('roles.index') }}" class="nav-link nav-toggle">
            <i class="fa fa-adn"></i>
            <span class="title">Roles</span>
          </a>
        </li>
      @endcan     
    </ul>
  </div>
</div>

@section('backend-script')
  <script>
    $("#item_id li a").click(function() {
        $('#item_li').parent().addClass('start active open').siblings().removeClass('start active open');
    });
  </script>
@endsection
