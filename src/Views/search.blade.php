@extends('task::app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Search") }}</div>
                <div class="card-body">
                    <form method="get" action="{{ route('searchIndex') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="search" class="col-sm-4 col-form-label text-md-right">{{ __("Search in Mawdoo3") }}</label>
                            <div class="col-md-6">
                                <input id="search" type="text" class="form-control" name="search" value="{{ old('search') }}" required autofocus />

                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Search") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(count($searchData)>0)
        <form method="post" action="{{ route('saveResults') }}">
                @csrf
            <table class="table">
                <thead>
                    <th>Select</th>
                    <th>title</th>
                    <th>description</th>
                    <th>Link</th>
                    <th>Comment</th>
                </thead>
                <tbody>
                    @foreach($searchData as $k=>$item)
                    <tr>
                        <td>
                            <input type="checkbox" id="item[{{$k}}][isSelected]" name="item[{{$k}}][isSelected]" data-old="{{$item['title']}}" value="" onchange="change(this,{{$k}})"/>
                            <input type="hidden" id="item[{{$k}}][title]" name="item[{{$k}}][title]" value="" data-old="{{$item['title']}}" />
                            <input type="hidden" id="item[{{$k}}][description]" name="item[{{$k}}][description]" value="" data-old="{{$item['description']}}" />
                            <input type="hidden" id="item[{{$k}}][link]" name="item[{{$k}}][link]" value="" data-old="{{$item['formattedUrl']}}" />
                        </td>
                        <td>{{$item["title"] }}</td>
                        <td> {{ $item["description"] }}</td>
                        <td><a href="{{ $item['formattedUrl'] }}">{{ $item["formattedUrl"] }}</a></td>
                        <td><textarea  id="item[{{$k}}][comment]" name="item[{{$k}}][comment]" value="" data-old="" ></textarea></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __("Save") }}</button>
                </div>
            </div>
        </form>
    @endif
    <script>
        var app = @json($searchData);
        var selected = {};
        var byId=(id)=>{return document.getElementById(id);};
        var change =(check,id)=>{
            let desc = byId("item["+id+"][description]");
            let title = byId("item["+id+"][title]");
            let url = byId("item["+id+"][link]");
            let comment = byId("item["+id+"][comment]");
            if(check.checked){
                check.value=true;
                desc.value=desc.dataset.old;
                title.value=title.dataset.old;
                url.value=url.dataset.old;
                comment.value=(comment.value)?comment.value:comment.dataset.old;
            }else{
                check.value=false;
                desc.value="";
                title.value="";
                url.value="";
                comment.dataset.old=comment.value;
                comment.value=comment.value;
            }
        }
    </script>
 
</div>
@endsection
