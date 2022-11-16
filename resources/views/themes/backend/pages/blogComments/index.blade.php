@extends('themes.backend.layouts.app')
@section('dataTables') @stop


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5>All Blogs comments</h5>
            </div>
            <div class="card-block">
                <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                <form id="listDataForm" name="listDataForm" method="post">
                    {{csrf_field()}}
                    <div class="table-responsive dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Comment
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Client IP
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogComments['comments'] as $blogComment)
                                <tr role="row" class="">
                                    <td>
                                        {{$blogComment['email']}}
                                    </td>
                                    <td>
                                        {{$blogComment['comment']}}
                                    </td>
                                    <td>
                                        {{$blogComment['name']}}
                                    </td>
                                    <td>
                                        <label id="change_status{{ $blogComment['id'] }}" onclick="return changeStatus('id', '{{ $blogComment['id'] }}', 'blog_comments', '{{ $blogComment['status'] }}', '{{ $statusAtrArr['status_type'] }}','/admin39/change-status');" class="label btn-{{ $listDataAtrArr['alert_css'][$blogComment['status']] }}">{{ $statusAtrArr['label'][$blogComment['status']] }}</label>
                                    </td>
                                    <td>
                                        {{$blogComment['client_ip_address']}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop