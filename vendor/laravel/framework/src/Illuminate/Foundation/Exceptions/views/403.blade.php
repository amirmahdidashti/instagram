@extends('errors::minimal')

@section('title', __('دسترسی غیر مجاز'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'دسترسی غیر مجاز'))
