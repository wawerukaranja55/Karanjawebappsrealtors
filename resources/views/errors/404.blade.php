@extends('Front.frontmaster')
@section('title','404 Error Page')
@section('content')
@section('403pagestyles')
    <style>

        .403page {
        font: normal 100%/1.15 "Merriweather", serif;
        background: #fff url("https://www.dropbox.com/s/0czxq7wr862we98/texture.jpg?raw=1") repeat 0 0;
        color: #fff;
        }

        /* https://www.vecteezy.com/vector-art/87721-wood-fence-vectors */
        .wrapper {
        position: relative;
        max-width: 1298px;
        height: auto;
        margin: 2em auto 0 auto;
        }

        /* https://www.vecteezy.com/vector-art/237238-dog-family-colored-doodle-drawing */
        .box {
        max-width: 70%;
        min-height: 400px;
        margin: 0 auto;
        padding: 1em 1em;
        text-align: center;
        }

        h1 {
        margin: 0 0 1rem 0;
        font-size: 8em;
        text-shadow: 0 0 6px #8b4d1a;
        }

        span {
        
        }

        span:first-of-type {
        margin-top: 16em;
        text-shadow: none;
        }

        span > a:hover { text-shadow: 0 0 3px #8b4d1a; }

        span img { vertical-align: bottom; }

        /* @media screen and (max-width: 600px) {
        /* .wrapper {
            background-size: 300px 114px;
            background-position: center top 22em;
            } 

        .box {
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
            background-size: 320px 185px;
        }

        span:first-of-type { margin-top: 12em; }
        } */
    </style>
@stop
    <div class="container 403page">
        <div class="row">
            <div class="wrapper">
                <div class="box">
                    <h1>404</h1>
                    <span
                    style="margin-bottom: 0.5em;
                    font-size: 1.75em;
                    color: #ea8a1a;">Sorry, Page Not Found!</span>
                    <span><a href="{{route ('home.index') }}" 
                        style="border-bottom: 1px dashed #837256;
                        font-style: italic;
                        text-decoration: none;
                        color: #837256;">Please, go back this way.</a></span>
                    </div>
                </div>        
        </div>
    </div>
@endsection






