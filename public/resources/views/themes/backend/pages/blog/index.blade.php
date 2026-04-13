@extends('themes.backend.layouts.app')
@section('dataTables') @stop


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card m-b-0">
            <div class="card-header">
                <h5>All Blogs</h5>
                <!-- Add New -->

                @if($roleRights['add'])
                <x-link_add_new url="{{ route('admin.blog.create') }}" />
                @endif
                <!-- Multi Delete -->

                @if($roleRights['delete'])
                <x-form.btn_multi_delete />
                @endif
                &nbsp;
            </div>
            <div class="card-block">
                <x-form.alert type="{{ session()->get('alert') }}" title="{{ session()->get('title') }}" message="{{ session()->get('message') }}" />
                <form id="listDataForm" name="listDataForm" method="post" action="{{ route('admin.blog.delete') }}">
                    {{csrf_field()}}
                    <div class="table-responsive dt-responsive">
                        <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th class="cc-w-35 no-sort-del">
                                        <x-form.field.checkbox style="default" name="check_all" id="check_all" />
                                    </th>
                                    <th>
                                        {{__('blog.title_txt')}}
                                    </th>
                                    <th>
                                        {{__('blog.tags')}}
                                    </th>
                                    <th>
                                        {{__('blog.status')}}
                                    </th>
                                    <th>
                                        Created By
                                    </th>
                                    <th>
                                        Comments
                                    </th>
                                    <th>
                                        Published By
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                <tr role="row" class="">
                                    <td class="id">
                                        <x-form.field.checkbox style="default" name="checkbox[]" value="{{$blog->id}}" fldclass="del-chkbx" />
                                    </td>
                                    <td>
                                        @if($roleRights['edit'])
                                        <x-link_tooltip url="{{ route('admin.blog.edit', $blog->id) }}" title="Edit">
                                            {{$blog->heading}}
                                        </x-link_tooltip>
                                    </td>
                                    @else
                                    {{$blog->heading}}
                                    @endif
                                    <td>
                                        {{$blog->tags}}
                                    </td>
                                    <td>

                                        <label id="change_status{{ $blog->id }}" onclick="return changeStatus('id', {{ $blog->id }}, 'blog', {{ $blog->status }}, '{{ $statusAtrArr['status_type'] }}');" class="label btn-{{ $listDataAtrArr['alert_css'][$blog->status] }}">{{ $statusAtrArr['label'][$blog->status] }}</label>
                                    </td>
                                    <td>
                                        {{$blog->creator->first_name}}
                                    </td>
                                    <td>
                                        @if($blog->comments->count())
                                        <a href="{{route('admin.blog.comments', $blog->id)}}">View Comments ({{$blog->comments->count()}})</a>
                                        @else
                                        No comments
                                        @endif
                                    </td>
                                    <td>
                                        {{$blog->published_date}}
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