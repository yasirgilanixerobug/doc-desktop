@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '401')
@section('message', __($exception->getMessage()))
