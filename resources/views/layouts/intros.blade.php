<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name='csrf-token' content='{{csrf_token()}}' >
    <script src="{{asset('https://code.jquery.com/jquery-1.12.4.js')}}"></script>
    <script src="{{asset('https://code.jquery.com/ui/1.12.1/jquery-ui.js')}}"></script>
    <link href="{{asset('startbootstrap-modern-business/vendor/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <title>현지학기제</title>
</head>
<style>
/* .naver{
  margin-bottom: 6px;
  border: 15px solid black;
} */
</style>
<body>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-darkblue fixed-top">
  <a class="navbar-brand" href="{{url('/')}}">YORIYOI</a>
    <div class="container">
      <a class="navbar-brand" href="{{url('/')}}">      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- <div class="collapse navbar-collapse" id="navbarResponsive"> -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="/introduce">조원 소개</a>

          </li>
          <li class="nav-item">
            <a class="nav-link" href="/intros">현지 학기제</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/questions">Q & A</a>
          </li>
          <li class="nav-item dropdown">
          @auth
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              내 상태
            </a>
            <div class="dropdown-menu dropdown-menu-right login-drop" aria-labelledby="navbarDropdownBlog">
              <i class="fa fa-user" aria-hidden="true" ></i>
              <a class="login-drop">:  {{auth()->user()->user_id}}</a>
              <br>
              <hr>
              <a class="dropdown-item" href="/profile"> 프로필 설정</a>
              <!-- <i class="fa fa-comment" aria-hidden="true" href="http://yjp.ac.kr" >프로필 설정</i> -->
              <!-- <a class="dropdown-item" href="http://yjp.ac.kr">영진</a> -->
            </div>
            @endauth
          </li>
        </ul>
      </div>
    </div>

                    @auth
                      <!-- 드롭다운으로 할것-->
                      <!-- <div class="namep">
                        <a>{{auth()->user()->user_id}}</a><span> 님 환영합니다</span>
                      </div>   -->
                        <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        @method('delete')
                          <div class="form-group1">
                            <!-- <button type="submit" class="btn btn-primary1">삭제</button> -->
                            <button type="submit" class="btn btn-primary1">logout</button>

                          </div>
                        </form>
                    @else
                    <!-- <div class="Login"> -->
                    <div class="form-group1">
                      <div class="btn btn-primary1">

                        <a href="{{ route('login.index') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register.index') }}">Register</a>
                        @endif
                    @endauth
                      </div>
                    </div>

        </div>
  </nav>
    @yield('content')  
    @yield('foot')
    @yield('script')
    
</body>
</html>