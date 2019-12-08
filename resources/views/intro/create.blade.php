<form id="formData" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="title">제목 : </label>
        </label><input type="text" name="title" id="title" class="form-control" >
    </div>
    <div class="form-group">
       <label for="place">장소 : </label>
        <input type="text" name="place" id="place" class="form-control" >
    </div>
    <div class="form-group">
        <label for="master">담당자 : </label>
        <input type="text" name="master" id="master" class="form-control" >
    </div>
    <div class="form-group">
    <label>요일 : </label>
        <div class='select_bar' id='weekset'>
            <button type="button" data-value="1" class='selec_off'>월요일</button>
            <button type="button" data-value="2" class='selec_off'>화요일</button>
            <button type="button" data-value="3" class='selec_off'>수요일</button>
            <button type="button" data-value="4" class='selec_off'>목요일</button>
            <button type="button" data-value="5" class='selec_off'>금요일</button>
            <button type="button" data-value="6" class='selec_off'>토요일</button>
            <button type="button" data-value="7" class='selec_off'>일요일</button>
        </div>
    </div>
    <div class="form-group">
        <label for="starttime">시작시간 : </label>
        <input type="time" name="starttime" id="starttime" class="form-control">
    </div>
    <div class="form-group">
        <label for="endtime">종료시간 : </label>
        <input type="time" name="endtime" id="endtime" class="form-control">
    </div>
    <div class="form-group">
        <textarea name="append" cols="30" rows="10" id="title" class="form-control" placeholder="세부사항"></textarea>
    </div>
    <div class="form-group">
        <label for="photo">사진 : </label>
        <input type="file" name="photo" id="photo">
        <span class='img_section'></span>
    </div>
    <div class="form-group">
        @if($lv)
        <button type='submit' class='btn btn-primary'> 등록하기 </button>
        @endif
        <button type='button' class='clsBtn btn btn-primary'>닫기</button>
    </div>
</form>
<script>
$(document).ready(function() {
    
    var weekset = '';
    $('.clsBtn').on('click',function(e){
        get_list({{$lv}});
    });
    $('.select_bar > button').on('click',function(){
        var val = $(this).attr('data-value');
        if($(this).hasClass("selec_off")){
            $(this).removeClass('selec_off');
            $(this).addClass('selec_on');
            weekset += val;
        }else{
            $(this).removeClass('selec_on');
            $(this).addClass('selec_off');
            weekset = weekset.replace(val,'');
        }
    });
    
    $('#formData').on('submit',function(e){
        e.preventDefault();
        var form = $('#formData')[0];
        // Create an FormData object 
        var data = new FormData(form);
        data.append('weekset',weekset);
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
                    if(data["status"]) get_list({{$lv}});
                }
            });
        }
    });
    $("#photo").change(function(){
        readURL(this);
    });
});
</script>
<style>
    .select_bar button { padding:15px 20px; font:bold 12px malgun gothic; }
    .select_bar .selec_off {background:#bbbbbb; color:#444444; border:solid 2px #dddddd; }
    .select_bar .selec_on {background:#0069d9; color:white; border:solid 2px #007bff;}
</style>