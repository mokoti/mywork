    {{ --未完了TODOリスト-- }}  
 <div id="todos-incomplete" class="todos-list row">
     <div class="col-sm-12 col-md-12">
         <h2><span></span></h2>
         <table class="table table-striped">
             <thead>
                 <tr>
                     <th class="title col-sm-12 col-md-6">タイトル</th>
                     <th class="created_at col-sm-6 col-md-2">作成日</th>
                     <th class="updated_at col-sm-6 col-md-2">更新日</th>
                     <th class="col-sm-12 col-md-2">&nbsp;</th>
                 </tr>
             </thead>
             <tbody>
@if (count($incompleteTodos) > 0)
    @foreach ($incompleteTodos as $todo)
                 <tr>
                     <td id="todo-{{ $todo->id }}">
                         <span class="browse">
                         {{ Form::open(['url' => route('todos.update', $todo->id)]) }}
                             <input type="hidden" name="title" value="{{{ $todo->title }}}">
                             <input type="hidden" name="status" value="{{ Todo::STATUS_COMPLETED }}">
                             <button class="btn btn-link" type="submit"><i class="glyphicon glyphicon-unchecked"></i></button>
                         {{ Form::close() }}
                            <span name="title">
                                {{{ $todo->title }}}
                            </span>
                            <span class="pull-right">
                                <button class="btn btn-link" type="button" name="edit" data-id="todo-{{ $todo->id }}"><i class="pluphicon glyphicon-edit"></i></button>
                            </span>
                         </span>
                         <span class="edit">
                            <input type="hidden" name="status" value={{ Todo::STATUS_COMPLETED }}>
                            <div class="input-group">
                                 <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" name="cancel" data-id="{{ $todo->id }}"><i class="glyphicon glyphicon-remove"></i></button>
                                 </span>
                                 <input class="form-control" type="text" name="title" value="{{{ $todo->title }}}">
                                 <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" name="update" data-id="todo-{{ $todo->id }}" data-url="{{ route('todos.update-title', $todo->id) }}">変更</button>
                                 </span>
                             </div>
                         </span>
                     </td>
                     <td>
                        {{ data_string($todo->created_at) }}
                     </td>
                     <td>
                        {{ data_string($todo->updated_at) }}
                     </td>
                     <td class="btn-group">
                        {{ Form::open(['url' => route('todos.delete', $todo->id)]) }}
                            <button class="btn btn-danger" type="submit"><i class="glyphicon glyphicon-trash"></i></button>
                        {{ Form::close() }}
                     </td>
                 </tr>
    @endforeach
@else
                 <tr>
                     <td colspan="4">まだありません。</td>
                 </tr>
@endif
             </tbody>
         </table>
     </div>
 </div>
