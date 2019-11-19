<form id="formData" enctype="multipart/form-data">
    @csrf
    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
        제목 : <input type="text" name="title" value="{{$intro->title}}"> {!! $errors->first('title', '<span class="form-error">:message</span>') !!}<br/>
        장소 : <input type="text" name="place" value="{{$intro->place}}"><br/>
        담당자 : <input type="text" name="master" value="{{$intro->master}}"> {!! $errors->first('master', '<span class="form-error">:message</span>') !!}<br/>
        요일 : 
        <select name="weekset[]" multiple="multiple" size="7" data-key="{{$intro->weekset}}">
        </select><br/>
        시작시간 : <input type="time" name="starttime" value="{{$intro->starttime}}"><br/>
        종료시간 : <input type="time" name="endtime" value="{{$intro->endtime}}"><br/>
        <textarea name="append" cols="30" rows="10" placeholder="세부사항">{{$intro->append}}</textarea><br/>
        사진 : <input type="file" name="photo"><br/>
        <button type="submit" class="modBtn" data-id="{{$intro->id}}"> 수정하기 </button>
        <button type="button" class="clsBtn">닫기</button>
    </div>
</form>

<script>
    var weekend = ['월','화','수','목','금','토','일'];
    var select = $('select[name="weekset[]"]');
    var key = select.attr('data-key');
    for(i = 0; i<7; i++){
        var l = i + 1;
        var option = $('<option value="'+(l)+'"> ' + weekend[i] + ' </option>');
        if( key.indexOf(l) != -1){ // 문자열 찾기
            option = $('<option value="'+(l)+'" selected="selected"> ' + weekend[i] + ' </option>');
        } 
        select.append(option);
    }
    $('.clsBtn').on('click',function(e){
        $('.btmBlk').empty();
    });
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.modBtn').on('click',function(e){
        // Get form
        var form = $('#formData')[0];
        var introId = $(this).attr('data-id');
        // Create an FormData object 
        var data = new FormData(form);
        data.append('_method', 'PATCH');
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/intros/' + introId,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success : function(data){
                get_list();
                $('.btmBlk').empty();
            }
        });
        
    });
</script>