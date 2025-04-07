<a href="{{ "edit_code/" . $row->id }}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>  
<form  method="POST" action="{{ "destroy_code/". $row->id }}" style="display: inline;">
    @csrf
    <input name="_method" type="hidden" value="DELETE">
    <button type="submit" class="btn btn-sm btn-danger" onclick="showComfirmBox(this)" ><i class="far fa-trash-alt"></i></button>
</form>