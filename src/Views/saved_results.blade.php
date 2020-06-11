@extends('task::app') 
@section('content')
<div class="container">
@if(count($data)>0)
    <table border="1"  class="table table-hover">
        <thead>
            <th>title</th>
            <th>description</th>
            <th>Link</th>
            <th>Comment & Action</th>
        </thead>
        <tbody>
            @foreach($data as $k=>$item)
                <tr>
                    <td>{{$item["title"] }}</td>
                    <td> {{ $item["description"] }}</td>
                    <td><a href="{{ $item['link'] }}">{{ $item["link"] }}</a> </td>
                    <td>
                        <form method="post" class="form-horizontal" name="form{{$item['id']}}" action="{{ route('chooseAction',$item['id']) }}" >
                            <textarea  id="comment" name="comment" value="{{$item['comment']}}" data-old="" >{{$item['comment']}}</textarea>
                            <input type="hidden" id="delId" name="delId" value="{{$item['id']}}" data-old="{{$item['title']}}" >
                            @csrf
                            <button type="submit" name="action"  value="Delete" class="btn btn-primary">{{ __("Delete") }}</button>
                            <button type="submit" name="action"  value="Update" class="btn btn-primary">{{ __("Update") }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endif

 
</div>
@endsection