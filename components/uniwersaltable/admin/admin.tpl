
<table id="table">
<thead><tr style="text-align: center; font-weight: bold;">
	<td>name</td>
	<td>title</td>
	<td>required</td>
	<td>type</td>
</tr>
</thead>

{{$f->start()}}
<tr><td>{{$f->submit()}}</td></tr>

{{section name=i loop=20}}

<tr style="text-align: center;">
	<td>{{$f->text("name_`$smarty.section.i.index`")}}         </td>
	<td>{{$f->text("title_`$smarty.section.i.index`")}}        </td>
	<td>{{$f->checkbox("required_`$smarty.section.i.index`")}} </td>
	<td>{{$f->select("type_`$smarty.section.i.index`")}}       </td>
</tr>
{{/section}}

<tr><td>Authorized: </td><td>{{$f->checkbox('authorized')}} </td></tr>
<tr><td>id:         </td><td>{{$f->checkbox('id')}}         </td></tr>
<tr><td>Created at: </td><td>{{$f->checkbox('created_at')}} </td></tr>
<tr><td>Updated at: </td><td>{{$f->checkbox('updated_at')}} </td></tr>
<tr><td>Sessid:     </td><td>{{$f->checkbox('sessid')}}     </td></tr>
<tr><td>Id user:    </td><td>{{$f->checkbox('id_user')}}    </td></tr>
<tr><td>Foto:       </td><td>{{$f->checkbox('foto')}}    </td></tr>
<tr><td></td></tr>


<tr><td>Table:           </td><td>{{$f->text('table')}}    </td></tr>
<tr><td>Title:           </td><td>{{$f->text('title')}}    </td></tr>
<tr><td>AntyBot:         </td><td>{{$f->checkbox('antybot')}}    </td></tr>
<tr><td>Order:           </td><td>{{$f->text('order')}}    </td></tr>
<tr><td>FirstPage - show:         </td><td>{{$f->text('first_show')}}    </td></tr>
<tr><td>FirstPage - organization: </td><td>{{$f->select('first_organization')}}    </td></tr>


<tr><td>{{$f->submit()}}</td></tr>
{{$f->stop()}}
</table>