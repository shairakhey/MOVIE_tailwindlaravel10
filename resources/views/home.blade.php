<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie-Apps</title>
    @vite('resources/css/app.css')
</head>
<body>
    {{-- Header section --}}
    <div class="w-full h-auto min-h-screen flex flex-col">
      @include('navigasi')


         {{-- Banner section --}}
        <div class="w-full h-[512px] flex flex-col relative bg-black">
            @foreach ($banner as $bannerItem)
            {{-- Banner image section --}}
            <div class="flex flex-row items-center w-full h-full relative slide">
                <img src="{{$imageBaseURL}}/original{{$bannerItem->backdrop_path}}" class="absolute w-full h-full object-cover">
                <div class="w-full h-full absolute bg-black bg-opacity-40"></div>

                {{-- Title movie --}}
                <div class="w-10/12 flex flex-col ml-28 z-10">
                    <span class="font-bold font-inter text-4xl text-white">{{$bannerItem->title}}</span>
                    <span class="font-inter text-xl text-white w-1/2 line-clamp-2">{{$bannerItem->overview}}</span>
                    <a href="/movie/{{$bannerItem->id}}" 
                    class="bg-develobe-500 text-white pl-2 py-2 mt-5 font-inter pr-4 text-sm flex flex-row rounded-full items-center hover:drop-shadow-lg duration-200 w-fit">
                    <svg width='24' height='24' role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>VLC media player</title>
                    <path d="M12.0319 0c-.8823 0-1.0545.136-1.0545.136-.1738.056-.3556.255-.4105.43L9.683 3.3808c.4729.1729 1.3222.4266 2.2337.4266 1.0987 0 2.017-.3494 2.3763-.5075L13.4352.566c-.055-.1755-.237-.3707-.4067-
                    .4374 0 0-.1142-.1286-.9966-.1286zm3.5645 7.455c-.3601.34-1.3276.9373-3.6797.9373-2.2929 0-3.189-.5678-3.5213-.9113l-1.3887 4.4227c.2272.3614 1.2539 1.5594 4.8847 1.5594 3.7569 0 4.8539-1.3467 5.0649-1.6737zm-8.5897 4.4487l-1.0025 3.1922H4.3428c-.2486 0-.5097.1932-.5826.4315l-2.334 7.6317a.3962.3962 0 0 0-.0169.1537c-.0008.0053-.002.0099-.002.016 0 .0839.0233.226.
                    0233.226.0322.2456.2612.4452.5098.4452h20.1192c.2487 0 .4768-.1994.5098-.4453 0 0 .0234-.142.0234-.226a.0245.0245 0 0 0-.0025-.01.3201.3201 0 0 0 .0024-.0313.4096.4096 0 0 0-.019-.1282l-2.3339-7.6318c-.0729-.2383-.334-.
                    4314-.5826-.4314h-1.6636l.2005.6391c-.2407.4854-1.4886 2.38-6.3027 2.38-4.6003 0-5.8288-1.73-6.1107-2.3072z"/>
                    </svg>
                    <span>Detail Movie</span>
                    </a>
                </div>
                {{-- End title section --}}
            </div>
            {{-- End image section --}}
            @endforeach

            {{-- Prev and Next button --}}
            @if(count($banner) > 1)
            {{-- Next button --}}
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(1)">
                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
                <svg width='24' height='24' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="800px" width="800px" version="1.1" id="XMLID_287_" viewBox="0 0 24 24" xml:space="preserve">
                <g id="next">
	            <g>
		        <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12   "/>
	            </g>
                </g>
                </svg>
                </button>
            </div>
            {{-- End next button --}}
            {{-- Prev button --}}
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(-1)">
                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
                <svg width='24' height='24' xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 1024 1024" class="icon" version="1.1">
                    <path d="M768 903.232l-50.432 56.768L256 512l461.568-448 50.432 56.768L364.928 512z" fill="#000000"/>
                </svg>
                </button>
            </div>
            {{-- End prev button --}}
            @endif
            

            {{-- Indicator image section --}}
            <div class="absolute bottom-0 w-full mb-8">
                <div class="w-full flex flex-row items-center justify-center">
                    @for ($pos = 1; $pos <= count($banner); $pos++)
                        <div class="w-2.5 h-2.5 rounded-full dot mx-1 cursor-pointer" onclick="currentSlide({{$pos}})"></div>
                    @endfor                 
                </div>
            </div>
            {{-- End indicator image --}}
        </div>
        {{-- End banner section --}}
    </div>
    {{-- End header section --}}

    {{--- Top 10 movies section --}}
    <div class="mt-12">
        <span class="font-inter font-bold text-xl ml-28">Top 10 Movies</span>
        <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">
            @foreach ($loopMovies as $movieItem)

            @php 
                $original_date = $movieItem->release_date;
                $timestamp     = strtotime($original_date);
                $movieYear     = date("Y", $timestamp);

                $movieID       = $movieItem->id;
                $movieTitle    = $movieItem->title;
                $movieRating   = $movieItem->vote_average;
                $movieImage    = "{$imageBaseURL}/w500{$movieItem->poster_path}";
            @endphp
            <a href="movie/{{$movieID}}" class="group">
                <div class="min-w-[232px] min-h-[428px] bg-white drop-shadow-2xl group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                    <div class="rounded-[32px] overflow-hidden">
                        <img src="{{$movieImage}}" class="w-full h-[300px] rounded-[32px] group-hover:scale-150 duration-200">
                    </div>
                    <span class="font-inter font-bold text-xl mt-5 line-clamp-1 group-hover:line-clamp-none">{{$movieTitle}}</span>
                    <span class="font-inter font-bold text-sm mt-1">{{$movieYear}}</span>
                    <div class="items-center flex flex-row mt-1">
                        <svg width="24" height="24"  xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.9 4.5C15.9 3 14.418 2 13.26 2c-.806 0-.869.612-.993 1.82-.055.53-.121 1.174-.267 1.93-.386 2.002-1.72 4.56-2.996 5.325V17C9 19.25 9.75 20 13 20h3.773c2.176 0 2.703-1.433 2.899-1.964l.013-.036c.114-.306.358-.547.638-.82.31-.306.664-.653.927-1.18.311-.623.27-1.177.233-1.67-.023-.299-.044-.575.017-.83.064-.27.146-.475.225-.671.143-.356.275-.686.275-1.329 0-1.5-.748-2.498-2.315-2.498H15.5S15.9 6 15.9 4.5zM5.5 10A1.5 1.5 0 0 0 4 11.5v7a1.5 1.5 0 0 0 3 0v-7A1.5 1.5 0 0 0 5.5 10z" fill="#000000"/></svg>
                        <span class="font-inter text-sm mt-1">{{$movieRating}}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    {{--- End top 10 movies section --}}

    {{-- Script --}}
    <script>
        let slideIndex = 3;
        slideShow(slideIndex);

        // Move prev button
        function moveSlide(movestep) {
            slideShow(slideIndex += movestep);
        }

        function slideShow(position) {
            let index;
            const slides = document.getElementsByClassName("slide");

            // Looping effect
            if(position > slides.length) {slideIndex = 1}
            if(position < 1) {slideIndex = slides.length} 

            // Hide all slide
            for(index = 0; index < slides.length; index++) {
                slides[index].classList.add('hidden');
            }

            // Show slide active
            slides[slideIndex - 1].classList.remove('hidden');
        }
    </script>
    {{-- End script --}}
</body>
</html>