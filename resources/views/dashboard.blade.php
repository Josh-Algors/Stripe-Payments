<!-- <!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">Dashboard</a>
            <h4 class="navbar-brand mr-auto"> Welcome, {{ ucfirst($user->name) }}</h4>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
           
        </div>
    </nav> -->

@extends('layouts.master')
@section('body')
<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-left">Welcome, {{ ucfirst($user->name) }}</h3>
                    <div class="card-body">
                        <form method="POST" action="{{ route('addPays') }}">
                            @csrf
                            <div class="form-group mb-3">
                                
                                <select class="form-control" name="payment_method">
                                    <option value="" default>Select Payment Method</option>
                                        @foreach ($getPaymentMethod as $pm)
                                            <option  value="{{ $pm->payment_method }}" >{{ $pm->payment_method }}</option>
                                        @endforeach
                                </select>

                            </div>
                            <div class="d-grid mx-auto">
                                <button name="action" value="add" type="submit" class="btn btn-dark btn-block">Add</button>
                                <button name="action" value="remove" type="submit" class="btn btn-dark btn-block">Remove</button>

                            </div>
                            <br/>
                            <div class="form-group mb-3">
                            Select Available Payment Methods: <br/>
                            <select class="form-control">
                                <option value="" default>Select Payment Method</option>
                                
                                @foreach ($userPaymentMethod as $upm)
                               
                                <option  value="{{ $upm->payment_method }}" >{{ $upm->payment_method }}</option>
                                   
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <button name="action" value="pay" type="submit" class="btn btn-dark btn-block">Pay</button>
                            </div>
                            <input id="card-holder-name" type="text">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

