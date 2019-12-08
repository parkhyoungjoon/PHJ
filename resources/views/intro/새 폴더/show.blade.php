<ul>
    <li>{{$intro->title}}</li>
    <li>{{$intro->master}}</li>
    <li>{{$intro->place}}</li>
    <li>{{$intro->weekset}}</li>
    <li>{{$intro->starttime}} ~ {{$intro->endtime}}</li>
    <li>{{$intro->append}}</li>
    @if($intro->photo!='')
    <li><img src = "/images/{{$intro->photo}}" alt="{{$intro->title}}" width="200"/></li>
    @endif
</ul>
<div class='btnBlk'>
    @if($lv)
    <button type="button" onclick='load_page({{$intro->id}},"/edit")'>수정하기</button>
    <button type="button" onclick='intro_delete({{$intro->id}})'>삭제하기</button>
    @endif
    <button type='button' class='clsBtn'>닫기</button>
</div>
<script>
    $('.clsBtn').on('click',function(e){
        get_list();
    });
</script>