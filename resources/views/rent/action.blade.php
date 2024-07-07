<?php
$auth_user = authSession();
?>
{{ Form::open(['route' => ['rent.destroy', $id], 'method' => 'delete', 'data--submit' => 'rent' . $id]) }}
<div class="d-flex justify-content-end align-items-center">
    @if ($auth_user->can('rent show'))
        <a class="mr-2" href="{{ route('rent.show', $id) }}"><i class="fas fa-eye text-secondary"></i></a>
    @endif

    {{-- @if ($auth_user->can('rent edit'))
        <a class="mr-2" href="{{ route('rent.edit', $id) }}"
            title="{{ __('message.update_form_title', ['form' => __('message.rent')]) }}"><i
                class="fas fa-edit text-primary"></i></a>
    @endif --}}

    @if ($auth_user->can('rent delete'))
        <a class="mr-2" href="javascript:void(0)" data--submit="rent{{ $id }}" data--confirmation='true'
            data-title="{{ __('message.delete_form_title', ['form' => __('message.rent')]) }}"
            title="{{ __('message.delete_form_title', ['form' => __('message.rent')]) }}"
            data-message='{{ __('message.delete_msg') }}'>
            <i class="fas fa-trash-alt text-danger"></i>
        </a>
    @endif
</div>
{{ Form::close() }}
