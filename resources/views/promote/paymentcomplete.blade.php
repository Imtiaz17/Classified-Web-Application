@extends('layouts.master')

@section('before_styles')
<style type="text/css">



.site-header {
	margin: 0 auto;
	padding: 30px 0 0;
	max-width: 820px;
}
.site-header__title {
	margin: 0;
	font-family: Montserrat, sans-serif;
	font-size: 2.5rem;
	font-weight: 700;
	line-height: 1.1;
	text-transform: uppercase;
	-webkit-hyphens: auto;
	-moz-hyphens: auto;
	-ms-hyphens: auto;
	hyphens: auto;
}

.main-content {
	margin: 0 auto;
	text-align: center;
	max-width: 820px;
}
.main-content__checkmark {
	font-size: 3rem;
	line-height: 1;
	color: #24b663;
}
.main-content__body {
	margin: 20px 0 0;
	font-size: 1rem;
	line-height: 1.4;
}

.site-footer {
	margin: 0 auto;
	padding: 80px 0 25px;
	padding: 0;
	max-width: 820px;
}
.site-footer__fineprint {
	font-size: 0.9375rem;
	line-height: 1.3;
	font-weight: 300;
}

@media only screen and (min-width: 40em) {
	
	.site-header__title {
		font-size: 6.25rem;
	}
	.main-content__checkmark {
		font-size: 9.75rem;
	}
	.main-content__body {
		font-size: 1.25rem;
	}
	.site-footer {
		padding: 145px 0 25px;
	}
	.site-footer__fineprint {
		font-size: 1.125rem;
	}
}
	</style>
@endsection

@section('content')
<div class="container" style="background: #fff !important; margin: 15px auto;padding: 20px;text-align: center;">

	<header class="site-header" id="header">
		<h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
		<h3>Promotion request Successful !</h3>
	</header>

	<div class="main-content">
		<i style="font-size: 60px;" class="fa fa-check main-content__checkmark" id="checkmark"></i>
		<p class="main-content__body" data-lead-id="main-content-body">Thanks for your payment.<br>We will review your request and after approve your add will get boost !</p>
	</div>
	<br>
	<p class="lead">
		<a class="btn btn-primary btn-md" href="{{url('/')}}" role="button">Back to home</a>
	</p>
</div>


@endsection
