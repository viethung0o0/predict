<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Football Predict</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <link rel="stylesheet" href="/css/predict-football.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light static-top sb-navbar">
    <div class="container">
        <a class="navbar-brand" href="/">NEOLAB VN</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" style="">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mr-auto">
                @foreach($events as $item)
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('frontend.predict.football', $item->slug) !!}" title="Contact Start Bootstrap">{{$item->name}}</a>
                    </li>
                @endforeach
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownPremium" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(auth()->check())
                            <img class="img-responsive user-avatar" src="{!! auth()->user()->avatar !!}"/>
                            Hi! {!! auth()->user()->name !!}
                        @else
                            Hi!
                        @endif
                    </a>
                    @if(auth()->check())
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownPremium">
                            <a class="dropdown-item" href="{!! route('frontend.auth.logout') !!}">
                                <i class="icon-pencil fa-fw"></i>
                                Logout
                            </a>
                        </div>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#searchModal">
                        <i class="icon-magnifier"></i>
                        <span class="d-lg-none">Search</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container predict-champion">
    <h1 class="title">Neolab champion ship 2017</h1>
    <div class="champion-tropy">
        <img class="champion-img img-responsive rounded mx-auto d-block" src="/img/champion.png"/>
        <p class="champion-text">The winner will receive a value of {!! number_format($event['prize_value'], 0) !!}
            vnd</p>
    </div>
    {!! Form::open(['route' => ['frontend.predict.football', request()->route()->slug], 'class' => 'form-inline']) !!}
    <div class="team">
        <div class="position">
            <span class="number">1rd</span>
        </div>
        <div class="team-group row">
            <div class="team-item team-first col">
                {!! Form::select('1[team_1][team_id]', $teams, $footballPredictions[1]['team_1'] ?? null, [
                    'class' => $errors->has('1.team_1.team_id') ? 'form-control is-invalid' : 'form-control', 'required'
                ]) !!}
                <div class="score-group form-group">
                    {!! Form::number('1[team_1][score]', $footballPredictions[1]['score_1'] ?? null, [
                        'class' => $errors->has('1.team_1.score') ? 'form-control is-invalid' : 'form-control', 'required', 'min' => 0
                    ]) !!}
                    <span class="score-text">Score</span>
                </div>
            </div>
            <div class="team-item team-second col">
                <div class="score-group">
                    {!! Form::number('1[team_2][score]', $footballPredictions[1]['score_2'] ?? null, [
                        'class' => $errors->has('1.team_2.score') ? 'form-control is-invalid' : 'form-control', 'required', 'min' => 0
                    ]) !!}
                    <span class="score-text">Score</span>
                </div>
                {!! Form::select('1[team_2][team_id]', $teams, $footballPredictions[1]['team_2'] ?? null, [
                    'class' => $errors->has('1.team_2.team_id') ? 'form-control is-invalid' : 'form-control', 'required'
                ]) !!}
            </div>
        </div>
        <div class="position">
            <span class="number">3st</span>
        </div>
        <div class="team-group row">
            <div class="team-item team-first col">
                {!! Form::select('3[team_1][team_id]', $teams, $footballPredictions[3]['team_1'] ?? null, [
                    'class' => $errors->has('3.team_1.team_id') ? 'form-control is-invalid' : 'form-control', 'required'
                ]) !!}
                <div class="score-group">
                    {!! Form::number('3[team_1][score]', $footballPredictions[3]['score_1'] ?? null, [
                        'class' => $errors->has('3.team_1.score') ? 'form-control is-invalid' : 'form-control', 'required', 'min' => 0
                        ]) !!}
                    <span class="score-text">Score</span>
                </div>
            </div>
            <div class="team-item team-second col">
                <div class="score-group">
                    {!! Form::number('3[team_2][score]', $footballPredictions[3]['score_2'] ?? null, [
                        'class' => $errors->has('3.team_2.score') ? 'form-control is-invalid' : 'form-control', 'required', 'min' => 0
                    ]) !!}
                    <span class="score-text">Score</span>
                </div>
                {!! Form::select('3[team_2][team_id]', $teams, $footballPredictions[3]['team_2'] ?? null, [
                    'class' => $errors->has('3.team_2.team_id') ? 'form-control is-invalid' : 'form-control', 'required'
                ]) !!}
            </div>
        </div>
    </div>
    <div class="description">
        <div class="row">
            <div class="predict-number col">
                <p class="how-many">How many people have predict you?</p>
                <div class="form-group">
                    {!! Form::number('same_respondent_number', $sameRespondentNumber ?? null, [
                        'class' => $errors->has('same_respondent_number') ? 'form-control is-invalid' : 'form-control', 'required', 'min' => 0
                    ]) !!}
                </div>
            </div>
            <div class="rules col">
                <b>Rule:</b><br/>
                <div class="rule-content">
                    1. You must use @neo-lab.vn, @neo-lab.co.jp, @neo-lab.career.jp email to predict.<br/>
                    2. You can predict many times. We will get the last result.<br/>
                    3. You must predict before the match.<br/>
                </div>
            </div>
        </div>
        <div class="predict-choose">
            @if(auth()->check())
                {!! Form::submit('Predict', ['class' => 'btn btn-predict']) !!}
            @else
                <a href="{!! route('frontend.auth.redirect') !!}" class="btn btn-block btn-social btn-google">
                    <span class="fa fa-google"></span> Sign in
                </a>
            @endif
            <p>Good luck to you</p>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div>

</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/4fb74957ec.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
    @endif
</script>
</body>
</html>
