<div id="SubMenuMod_Page">
<ul>
{{foreach item=item from=$data}}
<li>
	<a href="{{$item.link}}">{{$item.name}}</a>
	<div class="desc">{{$item.title|default:$item.name}}</a>
</li>

{{/foreach}}
</ul>
</div>