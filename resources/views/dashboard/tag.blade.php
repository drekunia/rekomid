@extends('layouts.dashboard')

@section('title')
@if (url()->current() == route('tag.trash'))
Trashed Tags
@else
Tag List
@endif
@endsection

@section('button')
@if (url()->current() == route('tag.trash'))
<a href="{{ route('tag.index') }}" class="btn btn-primary float-right">Tag list</a>
@else
<a data-widget="control-sidebar" data-slide="true" href="#" role="button" class="btn btn-primary float-right">Create Tag</a>
@endif
@endsection

@section('content')
<!-- Read content -->
<div class="card">
  @if (count($tags) == 0)
  <div class="card-body mt-3">
    <p class="lead">No tags yet.</p>
  </div>
  @else
  <div class="card-body accordion" id="accordionEdit">
    <table id="categoryTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Tag Name</th>
          <th>Tag Slug</th>
          <th width="1%"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($tags as $tag)
        <tr>
          <td data-label="Tag Name">{{ $tag->name }}</td>
          <td data-label="Tag Slug">{{ $tag->slug }}</td>
          <td>
            <div class="d-flex flex-row">
              @if (url()->current() == route('tag.trash'))
              <form action="{{ route('tag.restore', $tag->id) }}" method="POST">
                @csrf
                <input type="submit" class="btn btn-success btn-sm mx-1" value="Restore">
              </form>
              <form action="{{ route('tag.kill', $tag->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-danger btn-sm mx-1" onClick="deleteConfirm()" value="Delete">
              </form>
              @else
              <button class="btn btn-success btn-sm mx-1" type="button" data-toggle="collapse" id="editButton{{ $tag->id }}" data-target="#editCollapse{{ $tag->id }}" aria-expanded="true" aria-controls="editCollapse{{ $tag->id }}">
                Edit
              </button>
              <form action="{{ route('tag.destroy', $tag->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" class="btn btn-danger btn-sm mx-1" onClick="deleteConfirm()" value="Delete">
              </form>
              @endif
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="3" id="editCollapse{{ $tag->id }}" class="collapse" aria-labelledby="editButton{{ $tag->id }}" data-parent="#accordionEdit">
            <div id="editCollapse{{ $tag->id }}" class="collapse" aria-labelledby="editButton{{ $tag->id }}" data-parent="#accordionEdit">
              <form role="form" action="{{ route('tag.update', $tag->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <!-- form start -->
                <div class="card-body">
                  <div class="form-group">
                    <label for="tag">Edit Tag Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Add tag name..." value="{{ $tag->name }}">
                  </div>
                  <div class="float-right">
                    <button type="submit" id="submit" class="btn btn-primary btn-sm">Submit</button>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
          </td>
          <td style="display: none;"></td>
          <td style="display: none;"></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
  <div class="mx-auto">
    {{ $tags->links() }}
  </div>
  @endif
</div>
<!-- /.card -->
@endsection

@section('right-sidebar')
<!-- Control Sidebar -->
<aside class="control-sidebar form-control-sidebar control-sidebar-dark elevation-2 overflow-auto">
  <!-- Control sidebar content goes here -->
  <div class="p-3">
    <div class="d-flex flex-row justify-content-end">
      <a data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-times-circle"></i></a>
    </div>
    <!-- form start -->
    <form role="form" id="createForm" action="{{ route('tag.store')}}" method="POST">
      @csrf
      <div class="form-group">
        <label for="tag">Create Tag</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Add tag name...">
      </div>
      <div class="float-right">
        <button type="submit" id="createSubmit" class="btn btn-primary btn-sm">Submit</button>
      </div>
    </form>
  </div>
</aside>
<!-- /.control-sidebar -->
@endsection

@section('script')
<!-- page script -->
<script>
function deleteConfirm() {
  if (confirm('Are you sure you want to delete this tag?')) {
    //
  } else {
    event.preventDefault();
  }
}
$(document).on('click', '#createSubmit', function() {
  $("#createForm").submit();
});

</script>
@endsection
