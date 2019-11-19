<form action="/post" method="POST">
<select name="weekset" multiple="multiple" size="7">
    <option value="1">월</option>
    <option value="2">화</option>
    <option value="3">수</option>
    <option value="4">목</option>
    <option value="5">금</option>
    <option value="6">토</option>
    <option value="7">일</option>
</select>
<button>fdsfdsfds</button>
</form>
<?php
    if(isset($_POST['weekset'])) echo $_POST['weekset'];
?>