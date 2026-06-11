@props(['theme' => 'border', 'type' => 'info', 'title'=>'', 'message'=>''])

@if($type)
<div {{ $attributes->merge(['class' => 'alert alert-'.$type.' '.$theme.'-'.$type]) }}>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
	@if($title)
	<strong>{!! $title !!}&nbsp;</strong>
	@endif  
	{!! $message !!}
</div>
@endif

@if (count($errors) > 0)
  <div class="alert alert-danger {{ $theme.'-danger' }}">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button>
      <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif