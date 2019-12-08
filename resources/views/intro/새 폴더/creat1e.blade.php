  <form id="formData" enctype="multipart/form-data">
    @csrf
    <div>
        제목
        <br>
        <input type="text" name="title" id="title"><br/>
        장소
        <br>
        <input type="text" name="place" id="place"><br/>
        담당자<br>
        <input type="text" name="master" id="master"><br/>
        요일 <br> 
        <select name="weekset[]" multiple="multiple" size="7" id="weekset">
            <option value="1">월요일</option>
            <option value="2">화요일</option>
            <option value="3">수요일</option>
            <option value="4">목요일</option>
            <option value="5">금요일</option>
            <option value="6">토요일</option>
            <option value="7">일요일</option>
        </select>
        <br/>
        시작시간
        <br>
        <input type="time" name="starttime" id="starttime"><br/>
        종료시간
        <br>
        <input type="time" name="endtime" id="endtime"><br/>
        <textarea name="append" cols="30" rows="10" placeholder="세부사항" id="append"></textarea><br/>
        사진 : <input type="file" name="photo"><br/>
        <div class='btnBlk'>
            @if($lv)
            <button type='submit' class='addBtn'> 등록하기 </button>
            @endif
            <button type='button' class='clsBtn'>닫기</button>
        </div>
    </div>
</form>
<script>
$(document).ready(function() {
    $('.clsBtn').on('click',function(e){
        get_list();
    });
    $('#formData').on('submit',function(e){
        e.preventDefault();
        var form = $('#formData')[0];
        // Create an FormData object 
        var data = new FormData(form);
        if(valid_chk(data)){
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: '/intros',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success : function(data){
                    alert(data["message"]);
                    if(data["status"]) get_list();
                }
            });
        }
    });
});
</script>