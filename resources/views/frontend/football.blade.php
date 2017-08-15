<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Football Predict</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/predict-football.css"/>
</head>
<body>
<div class="container predict-champion">
    <h1 class="title">Neolab champion ship 2017</h1>
    <div class="champion-tropy">
        <img class="champion-img img-responsive rounded mx-auto d-block" src="/img/champion.png"/>
        <p class="champion-text">The winner will receive a value of 1,000,000 vnd</p>
    </div>
    {!! Form::open(['class' => 'form-inline']) !!}
    <div class="team">
        <div class="position">
            <span class="number">3rd</span>
        </div>
        <div class="team-group row">
            <div class="team-item team-first col">
                <select class="form-control" name="team_1[]">
                    <option value="1">Team 1</option>
                    <option value="2">Team 2</option>
                    <option value="3">Team 3</option>
                    <option value="4">Team 4</option>
                </select>
                <div class="score-group">
                    <input class="form-control" name="score_1[]" value=""/> <span class="score-text">Score</span>
                </div>
            </div>
            <div class="team-item team-second col">
                <div class="score-group">
                    <input class="form-control" name="score_1[]" value=""/> <span class="score-text">Score</span>
                </div>
                <select class="form-control" name="team_1[]">
                    <option value="1">Team 1</option>
                    <option value="2">Team 2</option>
                    <option value="3">Team 3</option>
                    <option value="4">Team 4</option>
                </select>
            </div>
        </div>
        <div class="position">
            <span class="number">1st</span>
        </div>
        <div class="team-group row">
            <div class="team-item team-first col">
                <select class="form-control" name="team_2[]">
                    <option value="1">Team 1</option>
                    <option value="2">Team 2</option>
                    <option value="3">Team 3</option>
                    <option value="4">Team 4</option>
                </select>
                <div class="score-group">
                    <input class="form-control" name="score_2[]" value=""/> <span class="score-text">Score</span>
                </div>
            </div>
            <div class="team-item team-second col">
                <div class="score-group">
                    <input class="form-control" name="score_2[]" value=""/> <span class="score-text">Score</span>
                </div>
                <select class="form-control" name="team_2[]">
                    <option value="1">Team 1</option>
                    <option value="2">Team 2</option>
                    <option value="3">Team 3</option>
                    <option value="4">Team 4</option>
                </select>
            </div>
        </div>
    </div>
    <div class="description">
        <div class="row">
            <div class="predict-number col">
                <p class="how-many">How many people have predict you?</p>
                <div class="form-group">
                    <input class="form-control" type="text" name="predict_number" value=""/>
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
            {!! Form::submit('Predict', ['class' => 'btn btn-predict']) !!}
            <p>Good luck to you</p>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div>

</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>