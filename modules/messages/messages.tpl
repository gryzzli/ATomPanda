
<div id="system-message">







{{if $data.message.0 != ""}}
{{foreach item=item from=$data.message}}
<div class="alert alert-success" role="alert">{{$item}}</div>
{{/foreach}}

{{/if}}

{{if $data.debug.0 != ""}}

{{foreach item=item from=$data.debug}}
<div class="alert alert-info" role="alert">{{$item|nl2br}}</div>
{{/foreach}}

{{/if}}






{{if $data.error.0 != ""}}

{{foreach item=item from=$data.error}}
<div class="alert alert-danger" role="alert">{{$item}}</div>
{{/foreach}}

{{/if}}


{{if $data.notice.0 != ""}}

{{foreach item=item from=$data.notice}}
<div class="alert alert-warning" role="alert">{{$item}}</li></div>
{{/foreach}}

{{/if}}



</div>