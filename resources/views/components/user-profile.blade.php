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
    <span class="label label-danger">
    @switch($user->role)
      @case('student')
        學生
        @break
      @case('admin')
        管理員
        @break
      @case('teacher')
        學生
        @break
    @endswitch
    </span>&nbsp;
    <span class="label label-primary">
    @if ($user->gender === 'Male')
        男
    @else
        女
    @endif
    </span>
      @if ($user->role == 'teacher' && $user->section_id > 0)
        <small>Class Teacher of Section: <span class="label label-info">{{ucfirst($user->section->section_number)}}</span></small>
      @endif
      
      @if($user->role == "student")
       <button class="btn btn-xs btn-success pull-right" role="button" id="btnPrint"><i class="material-icons">print</i> 列印</button>
       <div class="visible-print-block" id="profile-content">
       <div class="row">
          <div class="col-md-12">
            <div class="col-xs-8">
              <h2>{{$user->section->class->school->name}}</h2>
              <div style="font-size: 10px;">{{$user->section->class->school->about}}</div>
            </div>
            <div class="col-xs-4">
              <h3>學生資訊</h3>
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
                  <td>學號</td>
                  <td>{{$user->student_code}}</td>
                  <td>姓名</td>
                  <td>{{$user->name}}</td>
                </tr>
                <tr>
                  <td>教室</td>
                  <td>{{$user->section->class->class_number}}</td>
                  <td>班級</td>
                  <td>{{$user->section->section_number}}</td>
                </tr>
                <tr>
                  <td>學年度</td>
                  <td>{{$user->studentInfo['session']}}</td>
                  <td>版本</td>
                  <td>{{$user->studentInfo['version']}}</td>
                </tr>
                <tr>
                  <td>群組</td>
                  <td>{{$user->studentInfo['group']}}</td>
                  <td colspan="2"></td>
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
              學生資料
            </p>
            <div class="col-xs-12">
              <table class="table">
                <tr>
                  <td>電子信箱</td>
                  <td>{{$user->email}}</td>
                  <td>聯絡電話</td>
                  <td>{{$user->phone_number}}</td>
                </tr>
                <tr>
                  <td>性別</td>
                  <td>{{$user->gender}}</td>
                  <td>血型</td>
                  <td>{{$user->blood_group}}</td>
                </tr>
                <tr>
                  <td>國籍</td>
                  <td>{{$user->nationality}}</td>
                  <td>生日</td>
                  <td>{{Carbon\Carbon::parse($user->birthday)->format('d/m/Y')}}</td>
                </tr>
                <tr>
                  <td>宗教</td>
                  <td>{{$user->studentInfo['religion']}}</td>
                  <td>父親名稱</td>
                  <td>{{$user->studentInfo['father_name']}}</td>
                </tr>
                <tr>
                  <td>母親名稱</td>
                  <td>{{$user->studentInfo['mother_name']}}</td>
                  <td>地址</td>
                  <td>{{$user->address}}</td>
                </tr>
                <tr>
                  <td>手機</td>
                  <td>{{$user->phone_number}}</td>
                  <td>父親手機</td>
                  <td>{{$user->studentInfo['father_phone_number']}}</td>
                </tr>
                <tr>
                  <td>父親身分證</td>
                  <td>{{$user->studentInfo['father_national_id']}}</td>
                  <td>父親職業</td>
                  <td>{{$user->studentInfo['father_occupation']}}</td>
                </tr>
                <tr>
                  <td>父親備註</td>
                  <td>{{$user->studentInfo['father_designation']}}</td>
                  <td>父親年收入</td>
                  <td>{{$user->studentInfo['father_annual_income']}}</td>
                </tr>
                <tr>
                  <td>母親手機</td>
                  <td>{{$user->studentInfo['mother_phone_number']}}</td>
                  <td>母親身分證</td>
                  <td>{{$user->studentInfo['mother_national_id']}}</td>
                </tr>
                <tr>
                  <td>母親職業</td>
                  <td>{{$user->studentInfo['mother_occupation']}}</td>
                  <td>母親備註</td>
                  <td>{{$user->studentInfo['mother_designation']}}</td>
                </tr>
                <tr>
                  <td>母親年收入</td>
                  <td>{{$user->studentInfo['mother_annual_income']}}</td>
                  <td>描述</td>
                  <td>{{$user->about}}</td>
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
          <td><b>學年度</b></td>
          <td>{{$user->studentInfo['session']}}</td>
          @else
          <td><b>教室</b></td>
          <td>{{$user->student_code}}</td>
          <td><b>描述</b></td>
          <td>{{$user->about}}</td>
          @endif
        </tr>
        @if($user->role == "student")
        <tr>
          <td><b>教室</b></td>
          <td>{{$user->section->class->class_number}}</td>
          <td><b>班級</b></td>
          <td>{{$user->section->section_number}}</td>
        </tr>
        <tr>
          <td><b>版本</b></td>
          <td>{{$user->studentInfo['version']}}</td>
          <td><b>血型</b></td>
          <td>{{$user->blood_group}}</td>
        </tr>
        <tr>
          <td><b>群組</b></td>
          <td>{{$user->studentInfo['group']}}</td>
          <td><b>生日</b></td>
          <td>{{Carbon\Carbon::parse($user->birthday)->format('d/m/Y')}}</td>
        </tr>
        @endif
        <tr>
          <td><b>國籍</b></td>
          <td>{{$user->nationality}}</td>
          <td><b>宗教</b></td>
          <td>{{$user->studentInfo['religion']}}</td>
        </tr>
        @if($user->role == "student")
        <tr>
          <td><b>父親</b></td>
          <td>{{$user->studentInfo['father_name']}}</td>
          <td><b>母親</b></td>
          <td>{{$user->studentInfo['mother_name']}}</td>
        </tr>
        @endif
        <tr>
          <td><b>地址</b></td>
          <td>{{$user->address}}</td>
          <td><b>手機</b></td>
          <td>{{$user->phone_number}}</td>
        </tr>
        @if($user->role == "student")
        <tr>
          <td><b>父親手機</b></td>
          <td>{{$user->studentInfo['father_phone_number']}}</td>
          <td><b>父親身分證</b></td>
          <td>{{$user->studentInfo['father_national_id']}}</td>
        </tr>
        <tr>
          <td><b>父親職業</b></td>
          <td>{{$user->studentInfo['father_occupation']}}</td>
          <td><b>父親備註</b></td>
          <td>{{$user->studentInfo['father_designation']}}</td>
        </tr>
        <tr>
          <td><b>父親年收入</b></td>
          <td>{{$user->studentInfo['father_annual_income']}}</td>
          <td><b>母親手機</b></td>
          <td>{{$user->studentInfo['mother_phone_number']}}</td>
        </tr>
        <tr>
          <td><b>母親身分證</b></td>
          <td>{{$user->studentInfo['mother_national_id']}}</td>
          <td><b>母親職業</b></td>
          <td>{{$user->studentInfo['mother_occupation']}}</td>
        </tr>
        <tr>
          <td><b>母親備註</b></td>
          <td>{{$user->studentInfo['mother_designation']}}</td>
          <td><b>母親年收入</b></td>
          <td>{{$user->studentInfo['mother_annual_income']}}</td>
        </tr>
        <tr>
          <td><b>描述</b></td>
          <td colspan="3">{{$user->about}}</td>
        </tr>
        @endif
      </tbody>
    </table>
    </div>
  </div>
</div>
