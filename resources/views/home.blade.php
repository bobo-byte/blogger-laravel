@extends('layout')


@section('head')
    <link id="home-style" rel="stylesheet" href="assets/css/hugo.main.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="/js/plugins/readingtime.js"></script>
@endsection


@section('content')

@php
function getReadTime($allcontent = ''){
$total_word = str_word_count(strip_tags($allcontent));
$m = floor($total_word / 230);
$s = floor($total_word % 230 / (230 / 60));
$estimateTime = $m . ' minute' . ($m == 1 ? '' : 's') . ', ' . $s . ' second' . ($s == 1 ? '' : 's');
echo "<span title='Reading Time' dir='ltr'> · ☕&nbsp;{$estimateTime}&nbsp;read</span>";
}
@endphp
    @if(!empty($data) && $data->count())
    @foreach($data ?? '' as $key => $post)
    <div class="list__main lmr">
        <div class="summary__container" data-display="block">
            <article class="summary-classic" data-ani="true">
                <div class="summary-classic__flex-box">
                    <div class="summary-classic__image-container summary-classic__image-wrapper" data-position="right" data-hwm="">
                        <a href="/post/{{$post->id}}/show">
                            <img data-src="https://themes.gohugo.io//theme/hugo-theme-zzo/images/feature1/flowchart.png" alt="Flowchart support" src="https://themes.gohugo.io//theme/hugo-theme-zzo/images/feature1/flowchart.png" class="summary-classic__image lazyloaded" data-ani="true" data-hwm="" style="">
                        </a>
                    </div>
                    <div class="summary-classic__content">
                        <header>
                            <h5 class="title h5"><a href="/post/{{$post->id}}/show">{{$post->title}}</a> </h5>
                            <h6 class="subtitle caption">
                                @php
                                  $written_at = date('F d, Y', strtotime($post->created_at));
                                  echo "<time title='Written At' dir='ltr'>📅&nbsp;{$written_at}</time>";
                                  $time = getReadTime(strip_tags($post->body));
                                @endphp
                                <span> - Posted by, {{$post->author->name}} - </span>
                            </h6>
                        </header>
                        <div>
                            <div class="summary-classic__text p2">
                                <p class="article" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"> 
                                    {{strip_tags($post->body)}} </p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </article>
            @endforeach
            @endif

            {!! $data->links() !!}
        </div>
    
        <script> 
        
        document.addEventListener('DOMContentLoaded', function() {
            //removing redudant svg and correct margins for pagination from hugo.css
            document.getElementsByClassName('relative z-0 inline-flex shadow-sm rounded-md')[0].parentElement.remove();
            document.getElementsByClassName('text-sm text-gray-700 leading-5')[1].style.margin = "20px";
        });

       </script>

    <a href="/about"> About</a>
    <a href="/blog_post"> Post Exmaple</a>
    <a href="/welcome">Tutorials Laravel</a>
@endsection
