<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            @foreach($fundCompAnalysis['headers'] as $key=>$val)
                <th class="dark_bg">{{$val}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if($fundCompAnalysis['result'])
            @foreach($fundCompAnalysis['result'] as $key=>$valus)
            <tr>
                <td>
                    {{$key}}
                </td>
                @foreach ($valus as $val )
                    <td>
                        {{$val}}
                    </td>
                @endforeach
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="{{count($fundCompAnalysis['headers'])}}" align="center">No data</td>
        </tr>
        @endif

    </tbody>
</table>