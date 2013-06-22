<h1>Images</h1>
<div class="tablewrapper round5">
  <table class="imagelist">
  <thead>
    <th>Title</th>
    <th>Placement</th>
    <th>Action</th>
  </thead>
  <tbody>
  @foreach($images as $image)
      <tr>
          <td>{{ $image->title }}</td>
          <td>
            @if ($postid)
              {{ Form::select('placement['.$image->id.']', array(
                'main' => 'Main',
                'list' => 'In lists',
              ), $image->pivot->placement )}}
            @else
              {{ Form::select('placement['.$image->id.']', array(
                'main' => 'Main',
                'list' => 'In lists',
              ))}}
            @endif
          </td>
          <td>
            @if ($postid)
              {{ HTML::link('#', 'Detach', array('class' => 'jqDetachImageFromPost'))}}
            @else
              {{ HTML::link('#', 'Attach', array('class' => 'jqAttachImageToPost'))}}
            @endif
            {{ Form::hidden('image[]', $image->id) }}
          </td>
      </tr>
  @endforeach 
  </tbody>
  </table>
</div>
{{ $images->links() }}
