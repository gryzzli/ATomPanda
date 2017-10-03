<div class="MenuMod">
{{if $data.isSub == 1}}
<script>
$(document).ready(function(){

$(".hideMenu{{$data.id}}").hide(2000);
$(".hideButton{{$data.id}}").show(2000);

$(".hideButton{{$data.id}}").click(function(){
   $("li").show(500);
   $(".hideButton{{$data.id}}").hide(500);
});
});
</script>

{{/if}}





<h1>{{$data.name}}</h1>

{{if $data.isSub == 1}}
<button class="hideButton{{$data.id}} btn btn-info ">Pokaż resztę menu</button><br/><br/>
{{/if}}
<ul>
{{foreach from=$data.item item=item}}

<li {{$item.liStyle}}><a href="{{$item.link}} {{$item.addCode}}"> {{$item.name}}</a> {{$item.sub}}</li>

{{/foreach}}


</ul>
{{if $data.isSub == 1}}
<button class="hideButton{{$data.id}} btn btn-info">Pokaż resztę menu</button>
{{/if}}
</div>