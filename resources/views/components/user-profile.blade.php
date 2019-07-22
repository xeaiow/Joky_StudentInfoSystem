<div class="row">
  <div class="col-md-2">
    @if(!empty($user->pic_path))
    <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" class="img-thumbnail" id="my-profile" alt="Profile Picture" width="100%">
    @else
      @if(strtolower($user->gender) == 'male')
        <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/200/000000/user.png" class="img-thumbnail" width="100%">
      @else
        <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/200/000000/user-female.png" class="img-thumbnail" width="100%">
      @endif
    @endif
    @if(\Auth::user()->role == 'admin')
    <div class="rows" style="font-size:10px;margin-top:5%;">
      <input type="hidden" id="picPath" name="pic_path">
      <input type="hidden" id="userIdPic" name="user_id" value="{{$user->id}}">
      @component('components.file-uploader',['upload_type'=>'profile'])
      @endcomponent
    </div>
    @endif
  </div>
  <div class="col-md-10" id="main-container">
    <h3>{{$user->name}} 
    <span class="label label-primary">
      @switch($user->role)
        @case('student')
          學員
          @break
        @case('admin')
          管理員
          @break
        @case('teacher')
          教師
          @break
      @endswitch
    </span>&nbsp;
    
    @if ($user->gender == 'male')
      <span class="label label-success">男</span>
    @else
      <span class="label label-danger">女</span>
    @endif
      @if ($user->role == 'teacher' && $user->section_id > 0)
        <small>Class Teacher of Section: <span class="label label-info">{{ucfirst($user->section->section_number)}}</span></small>
      @endif
      
      @if($user->role == "student")
       <button class="btn btn-xs btn-success pull-right" role="button" id="btnPrint"><i class="material-icons">print</i> 列印</button>
       <div class="visible-print-block" id="profile-content">
       <div class="row">
          <div class="col-md-12">
            <div class="col-xs-8">
              <h2>{{ $user->section->class->school->name }}</h2>
              <div style="font-size: 10px;">{{$user->section->class->school->about}}</div>
            </div>
            <div class="col-xs-4">
              <h3>{{ $user->name }}</h3>
              <div style="font-size: 10px;">列印日期： {{Carbon\Carbon::now()->format('Y/m/d')}}</div>
            </div>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-md-12">
            <p class="bg-primary" style="text-align:center;">
              課程資料
            </p>
            <div class="col-xs-9">
              <table class="table">
                <tr>
                  <td>課程分類</td>
                  <td>{{ $user->section->class->class_number }}</td>
                  <td>班級/課程</td>
                  <td>{{ $user->section->section_number }}</td>
                </tr>
                <tr>
                  <td>學籍/入學年份</td>
                  <td>{{ $user->studentInfo['session'] }}</td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            </div>
            <div class="col-xs-3">
              @if(!empty($user->pic_path))
                <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" class="img-thumbnail" id="my-profile" alt="Profile Picture" width="120px" height="120px">
              @else
              @if(strtolower($user->gender) == 'male')
                <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/200/000000/user.png" class="img-thumbnail" id="my-profile" alt="Profile Picture" width="120px" height="120px">
              @else
                <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/200/000000/user-female.png" class="img-thumbnail" id="my-profile" alt="Profile Picture" width="120px" height="120px">
              @endif
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p class="bg-primary" style="text-align:center;">
              學生相關資料
            </p>
            <div class="col-xs-12">
              <table class="table">
                <tr>
                  <td>姓名</td>
                  <td>{{ $user->name }}</td>
                  <td>學號</td>
                  <td>{{ $user->student_code }}</td>
                </tr>
                <tr>
                  <td>性別</td>
                  <td>{{ ( $user->gender == 'male' ) ? '男' : '女' }}</td>
                  <td>出生年月日</td>
                  <td>{{ Carbon\Carbon::parse($user->birthday)->format('Y/m/d') }}</td>
                </tr>
                <tr>
                  <td>電子信箱</td>
                  <td>{{ $user->email }}</td>
                  <td>聯絡電話</td>
                  <td>{{ $user->phone_number }}</td>
                </tr>
                <tr>
                  <td>父親姓名</td>
                  <td>{{ $user->studentInfo['father_name'] }}</td>
                  <td>母親聯絡方式</td>
                  <td>{{ $user->studentInfo['mother_phone_number'] }}</td>
                </tr>
                <tr>
                  <td>母親姓名</td>
                  <td>{{ $user->studentInfo['mother_name'] }}</td>
                  <td>父親聯絡方式</td>
                  <td>{{ $user->studentInfo['father_phone_number'] }}</td>
                </tr>
                <tr>
                  <td>地址</td>
                  <td colspan="3">{{ $user->address }}</td>
                </tr>
                <tr>
                  <td>備註</td>
                  <td colspan="3">{{ $user->about }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
       </div>
       <script>
        $("#btnPrint").on("click", function () {
            var tableContent = $('#profile-content').html();
            var printWindow = window.open('', '', 'height=720,width=1280');
            printWindow.document.write('<html><head>');
            printWindow.document.write('<link href="{{url('css/app.css')}}" rel="stylesheet">');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<div class="container"><div class="col-md-12" id="academic-part">');
            printWindow.document.write(tableContent);
            printWindow.document.write('</div></div></body></html>');
            printWindow.document.close();
            // var academicPart = printWindow.document.getElementById("academic-part");
            // academicPart.appendChild(resultTable);
            printWindow.print();
          });
        </script>
      @endif
     </h3>
    <div class="table-responsive" style="margin-top: 3%;">
    <table class="table table-bordered table-striped">
      <tbody>
        <tr>
          @if($user->role == "student")
          <td><b>學號</b></td>
          <td>{{$user->student_code}}</td>
          <td><b>學籍/入學年份</b></td>
          <td>{{$user->studentInfo['session']}}</td>
          @else
          <td><b>課程類型</b></td>
          <td>{{$user->student_code}}</td>
          <td><b>描述</b></td>
          <td>{{$user->about}}</td>
          @endif
        </tr>
        @if($user->role == "student")
        <tr>
          <td><b>課程分類</b></td>
          <td>{{$user->section->class->class_number}}</td>
          <td><b>班級/課程</b></td>
          <td>{{$user->section->section_number}}</td>
        </tr>
        <tr>
          <td><b>出生年月日</b></td>
          <td>{{Carbon\Carbon::parse($user->birthday)->format('Y/m/d')}}</td>
          <td><b>備註</b></td>
          <td colspan="3">{{$user->about}}</td>
        </tr>
        <tr>
          <td><b>聯絡地址</b></td>
          <td>{{$user->address}}</td>
          <td><b>手機</b></td>
          <td>{{$user->phone_number}}</td>
        </tr>
        @endif
        @if($user->role == "student")
        <tr>
          <td><b>父親姓名</b></td>
          <td>{{$user->studentInfo['father_name']}}</td>
          <td><b>母親姓名</b></td>
          <td>{{$user->studentInfo['mother_name']}}</td>
        </tr>
        @endif
        @if($user->role == "student")
        <tr>
          <td><b>父親聯絡方式</b></td>
          <td>{{$user->studentInfo['father_phone_number']}}</td>
          <td><b>母親聯絡方式</b></td>
          <td>{{$user->studentInfo['mother_phone_number']}}</td>
        </tr>
        @endif
      </tbody>
    </table>
    </div>
  </div>
</div>
