<div class="MenuMod">
<h1>{{$data.name}}</h1>

<ul>
{{foreach from=$data.item item=item}}

<li><a href="{{$item.link}}"> {{$item.name}}</a> {{$item.sub}}</li>

{{/foreach}}
</ul>

</div>