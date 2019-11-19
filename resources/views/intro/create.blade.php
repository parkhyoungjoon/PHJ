<form id="formData" enctype="multipart/form-data">
    @csrf
    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
        제목 : <input type="text" name="title"> {!! $errors->first('title', '<span class="form-error">:message</span>') !!}<br/>
        장소 : <input type="text" name="place"><br/>
        담당자 : <input type="text" name="master"> {!! $errors->first('master', '<span class="form-error">:message</span>') !!}<br/>
        요일 : 
        <select name="weekset[]" multiple="multiple" size="7">
            <option value="1">월</option>
            <option value="2">화</option>
            <option value="3">수</option>
            <option value="4">목</option>
            <option value="5">금</option>
            <option value="6">토</option>
            <option value="7">일</option>
        </select>
        <br/>
        시작시간 : <input type="time" name="starttime"><br/>
        종료시간 : <input type="time" name="endtime"><br/>
        <textarea name="append" cols="30" rows="10" placeholder="세부사항"></textarea><br/>
        사진 : <input type="file" name="photo"><br/>
        <button type='submit' class='addBtn'> 등록하기 </button>
        <button type='button' class='clsBtn'>닫기</button>

    </div>
</form>
<script>
    $('.clsBtn').on('click',function(e){
        $('.btmBlk').empty();
    });
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.addBtn').on('click',function(e){
        // Get form
        var form = $('#formData')[0];
        
        // Create an FormData object 
        var data = new FormData(form);
        e.preventDefault();

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: '/intros',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            succsess : function(){
                get_list();
                $('.btmBlk').empty();
            }
        });
    });
</script>