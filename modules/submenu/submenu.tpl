<div id="SubMenuMod">
<ul>
{{foreach item=item from=$data}}
<li><a href="{{$item.link}}">{{$item.name}}</a></li>

{{/foreach}}
</ul>
</div>