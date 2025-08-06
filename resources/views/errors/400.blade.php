@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '400')
@section('message', __($exception->getMessage()))
