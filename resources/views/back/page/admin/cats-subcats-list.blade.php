@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Categories')
 @section('content')

 @livewire('admin-categories-sub-categories-list')
 @endsection
