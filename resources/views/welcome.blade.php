<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config("app.name") }}</title>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
  
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!--Replace with your tailwind.css once created-->

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">

	<!-- Define your gradient here - use online tools to find a gradient matching your branding-->
	<style>
		.gradient {
			background: linear-gradient(90deg, #d53369 0%, #daae51 100%);
		}
	</style>

</head>

<body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">

<!--Nav-->
<nav id="header" class="fixed top-0 z-30 w-full text-white gradient">
	<div class="container flex flex-wrap items-center justify-between w-full py-2 mx-auto mt-0">
        <a class="text-2xl font-bold text-white no-underline toggleColour hover:no-underline lg:text-4xl"  href="/"> 
            <div class="flex items-center pl-4">
                    <img class="h-24" src="{{ asset('images/handyman.png') }}" alt="Logo">
                    {{ config('app.name') }}
            </div>
        </a>

		<div class="block pr-4 lg:hidden">
			<button id="nav-toggle" class="flex items-center p-1 text-orange-800 hover:text-gray-900">
				<svg class="w-6 h-6 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
			</button>
		</div>

		<div class="z-20 flex-grow hidden w-full p-4 mt-2 text-black bg-white lg:flex lg:items-center lg:w-auto lg:mt-0 lg:bg-transparent lg:p-0" id="nav-content">
			<ul class="items-center justify-end flex-1 list-reset lg:flex">
                @if (Route::has('login'))
                    @auth
                        <li class="mr-3">
                            <a class="inline-block px-4 py-2 font-bold text-black no-underline" href="{{ url('/dashboard/user') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="mr-3">
                            <a class="px-8 py-4 mx-auto mt-4 font-bold text-gray-800 bg-white rounded-full shadow opacity-75 lg:mx-0 hover:underline lg:mt-0" href="{{ route('login') }}">Admin Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="mr-3">
                                <a class="inline-block px-4 py-2 font-bold text-black no-underline" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth
                @endif
			</ul>
		</div>
	</div>
	
	<hr class="py-0 my-0 border-b border-gray-100 opacity-25" />
</nav>




<!--Hero-->
<div class="pt-24">

	<div class="container flex flex-col flex-wrap items-center px-3 mx-auto md:flex-row">
		<!--Left Col-->
		<div class="flex flex-col items-start justify-center w-full text-center md:w-2/5 md:text-left">
			<p class="w-full uppercase tracking-loose">Having trouble with house chores?</p>
			<h1 class="my-4 text-5xl font-bold leading-tight">Let it be handled by Professionals</h1>
			<p class="mb-8 text-2xl leading-normal">Download {{ config('app.name') }} application in PlayStore or AppStore now!!</p>

            <div class="flex items-center justify-start w-full">
                <button class="flex px-8 py-4 my-6 ml-0 mr-2 font-bold text-gray-800 bg-white rounded-full shadow-lg lg:ml-2 lg:mr-0 hover:underline">
                    <svg class="h-5 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M19.665 16.811a10.316 10.316 0 0 1-1.021 1.837c-.537.767-.978 1.297-1.316 1.592c-.525.482-1.089.73-1.692.744c-.432 0-.954-.123-1.562-.373c-.61-.249-1.17-.371-1.683-.371c-.537 0-1.113.122-1.73.371c-.616.25-1.114.381-1.495.393c-.577.025-1.154-.229-1.729-.764c-.367-.32-.826-.87-1.377-1.648c-.59-.829-1.075-1.794-1.455-2.891c-.407-1.187-.611-2.335-.611-3.447c0-1.273.275-2.372.826-3.292a4.857 4.857 0 0 1 1.73-1.751a4.65 4.65 0 0 1 2.34-.662c.46 0 1.063.142 1.81.422s1.227.422 1.436.422c.158 0 .689-.167 1.593-.498c.853-.307 1.573-.434 2.163-.384c1.6.129 2.801.759 3.6 1.895c-1.43.867-2.137 2.08-2.123 3.637c.012 1.213.453 2.222 1.317 3.023a4.33 4.33 0 0 0 1.315.863c-.106.307-.218.6-.336.882zM15.998 2.38c0 .95-.348 1.838-1.039 2.659c-.836.976-1.846 1.541-2.941 1.452a2.955 2.955 0 0 1-.021-.36c0-.913.396-1.889 1.103-2.688c.352-.404.8-.741 1.343-1.009c.542-.264 1.054-.41 1.536-.435c.013.128.019.255.019.381z" fill="black"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg>
                    <span>IOS</span>
                </button>
                <button class="flex px-8 py-4 my-6 ml-0 mr-2 font-bold text-gray-800 bg-white rounded-full shadow-lg lg:ml-2 lg:mr-0 hover:underline">
                    <svg class="h-5 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 301"><path d="M78.389.858a8.824 8.824 0 0 0-4.19 1.089c-4.218 2.338-5.765 7.757-3.428 11.972l9.523 17.196C57.35 45.31 42.147 69.558 42.147 97.233v5.142c-4.407-5.07-10.884-8.271-18.121-8.271C10.766 94.104 0 104.87 0 118.129v74.009c0 13.258 10.767 24.025 24.026 24.025c7.237 0 13.714-3.202 18.12-8.272v10.367c0 13.977 11.437 25.413 25.414 25.413h6.448v32.923c0 13.26 10.767 24.026 24.026 24.026s24.025-10.767 24.025-24.026v-32.923h11.156v32.923c0 13.26 10.767 24.026 24.026 24.026s24.025-10.767 24.025-24.026v-32.923h6.449c13.976 0 25.413-11.436 25.413-25.413v-10.367c4.406 5.07 10.884 8.272 18.121 8.272c13.259 0 24.025-10.767 24.025-24.025v-74.009c0-13.259-10.766-24.025-24.025-24.025c-7.237 0-13.715 3.201-18.121 8.271v-4.272v-.245c.002-.26 0-.468 0-.625c0-27.67-15.238-51.894-38.174-66.09l9.55-17.224c2.336-4.215.79-9.634-3.428-11.972a8.824 8.824 0 0 0-4.19-1.089c-3.115-.03-6.172 1.612-7.782 4.517l-9.986 18.04c-9.764-3.603-20.388-5.578-31.48-5.578c-11.082 0-21.726 1.954-31.482 5.55L86.171 5.375C84.56 2.47 81.504.83 78.389.858z" fill="#FFF"/><path d="M24.026 100.362c-9.894 0-17.767 7.873-17.767 17.767v74.009c0 9.894 7.873 17.767 17.767 17.767c9.894 0 17.768-7.873 17.768-17.767v-74.009c0-9.894-7.874-17.767-17.768-17.767zm207.224 0c-9.895 0-17.768 7.873-17.768 17.767v74.009c0 9.894 7.873 17.767 17.768 17.767c9.894 0 17.767-7.873 17.767-17.767v-74.009c0-9.894-7.873-17.767-17.767-17.767z" fill="#A4C639"/><path d="M98.034 184.818c-9.894 0-17.768 7.873-17.768 17.768v74.008c0 9.894 7.874 17.767 17.768 17.767c9.894 0 17.767-7.873 17.767-17.767v-74.008c0-9.895-7.873-17.768-17.767-17.768zm59.207 0c-9.895 0-17.768 7.873-17.768 17.768v74.008c0 9.894 7.873 17.767 17.768 17.767c9.894 0 17.767-7.873 17.767-17.767v-74.008c0-9.895-7.873-17.768-17.767-17.768z" fill="#A4C639"/><path d="M78.443 7.117a2.47 2.47 0 0 0-1.197.326c-1.267.702-1.683 2.158-.98 3.428l12.517 22.611c-24.08 12.53-40.346 36.341-40.378 63.669H206.87c-.033-27.328-16.298-51.14-40.378-63.669l12.516-22.61c.704-1.27.287-2.727-.98-3.429a2.467 2.467 0 0 0-1.197-.326c-.9-.01-1.751.44-2.231 1.306l-12.68 22.855c-10.372-4.6-22.006-7.183-34.283-7.183c-12.277 0-23.91 2.582-34.283 7.183L80.674 8.423a2.486 2.486 0 0 0-2.23-1.306zm-30.038 96.292v114.85a19.113 19.113 0 0 0 19.155 19.154h120.155a19.113 19.113 0 0 0 19.155-19.155V103.41H48.405z" fill="#A4C639"/><path d="M91.068 54.923c-3.617 0-6.612 2.994-6.612 6.611c0 3.618 2.995 6.612 6.612 6.612c3.618 0 6.612-2.994 6.612-6.612c0-3.617-2.994-6.611-6.612-6.611zm73.138 0c-3.618 0-6.612 2.994-6.612 6.611c0 3.618 2.994 6.612 6.612 6.612c3.617 0 6.612-2.994 6.612-6.612c0-3.617-2.995-6.611-6.612-6.611z" fill="#FFF"/><rect x="0" y="0" width="256" height="301" fill="rgba(0, 0, 0, 0)" /></svg>
                    <span>Android</span>
                </button>
            </div>
		</div>
		<!--Right Col-->
		<div class="w-full py-6 text-center md:w-3/5">
			<img class="z-50 hidden w-full md:w-4/5 md:block" src="{{ asset('images/plumber.png') }}">
		</div>
		
	</div>

</div>


<div class="relative -mt-12 lg:-mt-24">
	<svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
	<g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
	<path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
	<path d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z" opacity="0.100000001"></path>
	<path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
	</g>
	<g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
	<path d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"></path>
	</g>
	</g>
	</svg>
</div>



<section class="py-8 bg-white border-b">
	<div class="container max-w-5xl m-8 mx-auto">
		<h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">What services you can get?</h1>
		<div class="w-full mb-4">	
			<div class="w-64 h-1 py-0 mx-auto my-0 rounded-t opacity-25 gradient"></div>
		</div>
	
		<div class="flex flex-wrap">
			<div class="w-5/6 p-6 sm:w-1/2">
				<h3 class="mb-3 text-3xl font-bold leading-none text-gray-800">Plumbing Jobs</h3>
				<p class="mb-8 text-gray-600">Planning to perform a plumbing job yourself. That's not as easy as it looks. Hop into our application and let the professionals handle it.<br /><br />
				
                    Say bye to leaking pipes in your home.
                </p>
				
			</div>
            <div class="w-full p-6 sm:w-1/2">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
  
                    <defs>
                        <pattern id="plumberpattern" x="0" y="0" width="1" height="1">
                          <image height="100%" style="object-fit: cover" xlink:href="https://surfed.com/assets/img/a/11315/main.jpg"/>
                        </pattern>
                    </defs>
                    
                    <path fill="url(#plumberpattern)" d="M47.1,-74.2C60.3,-64.8,69.7,-50.5,74.7,-35.3C79.7,-20.2,80.3,-4.3,77.1,10.4C73.9,25,66.9,38.5,56.5,47.2C46.2,55.9,32.5,59.9,17.9,66.8C3.4,73.7,-12,83.5,-23.9,80.4C-35.7,77.3,-44,61.3,-53,47.7C-62,34.1,-71.8,22.9,-76.5,9.3C-81.1,-4.4,-80.7,-20.5,-75.8,-36.1C-71,-51.6,-61.6,-66.5,-48.2,-75.7C-34.9,-85,-17.4,-88.7,-0.2,-88.4C17,-88,33.9,-83.6,47.1,-74.2Z" transform="translate(100 100)" />
                  </svg>
			</div>
		</div>
		
		
		<div class="flex flex-col-reverse flex-wrap sm:flex-row">
            <div class="w-full p-6 sm:w-1/2">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
  
                    <defs>
                        <pattern id="electricalpattern" x="0" y="0" width="1" height="1">
                          <image height="100%" style="object-fit: cover" xlink:href="https://www.recommend.my/blog/wp-content/uploads/2019/11/shutterstock_236101324-1000x667.jpg?is-pending-load=1"/>
                        </pattern>
                    </defs>
                    
                    <path fill="url(#electricalpattern)" d="M47.1,-74.2C60.3,-64.8,69.7,-50.5,74.7,-35.3C79.7,-20.2,80.3,-4.3,77.1,10.4C73.9,25,66.9,38.5,56.5,47.2C46.2,55.9,32.5,59.9,17.9,66.8C3.4,73.7,-12,83.5,-23.9,80.4C-35.7,77.3,-44,61.3,-53,47.7C-62,34.1,-71.8,22.9,-76.5,9.3C-81.1,-4.4,-80.7,-20.5,-75.8,-36.1C-71,-51.6,-61.6,-66.5,-48.2,-75.7C-34.9,-85,-17.4,-88.7,-0.2,-88.4C17,-88,33.9,-83.6,47.1,-74.2Z" transform="translate(100 100)" />
                  </svg>
			</div>	
			<div class="w-full p-6 mt-6 sm:w-1/2">
				<div class="align-middle">
					<h3 class="mb-3 text-3xl font-bold leading-none text-gray-800">Electrical Jobs</h3>
					<p class="mb-8 text-gray-600">Lights, fans or any other electrical appliances needs fixing. Don't worry about bringing to shop, book a professional's help using {{ config("app.name") }}.<br /><br />
					Light up your house. Be brighter be happy.
				</div>
			</div>
        </div>
        
        <div class="flex flex-wrap">
			<div class="w-5/6 p-6 mt-6 sm:w-1/2">
				<h3 class="mb-3 text-3xl font-bold leading-none text-gray-800">Furniture Assembly</h3>
				<p class="mb-8 text-gray-600">Trying to assemble furnitures bought from IKEA can be frustrating. Not anymore! Book a professional's help now.<br /><br />
				
                    Take a break from the IKEA furniture assembly instructions.
                </p>
				
            </div>
            <div class="w-full p-6 sm:w-1/2">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
  
                    <defs>
                        <pattern id="ikeapattern" x="0" y="0" width="1" height="1">
                          <image height="100%" style="object-fit: cover" xlink:href="https://www.ambista.com/media/view/71448/size/w950-16x9"/>
                        </pattern>
                    </defs>
                    
                    <path fill="url(#ikeapattern)" d="M47.1,-74.2C60.3,-64.8,69.7,-50.5,74.7,-35.3C79.7,-20.2,80.3,-4.3,77.1,10.4C73.9,25,66.9,38.5,56.5,47.2C46.2,55.9,32.5,59.9,17.9,66.8C3.4,73.7,-12,83.5,-23.9,80.4C-35.7,77.3,-44,61.3,-53,47.7C-62,34.1,-71.8,22.9,-76.5,9.3C-81.1,-4.4,-80.7,-20.5,-75.8,-36.1C-71,-51.6,-61.6,-66.5,-48.2,-75.7C-34.9,-85,-17.4,-88.7,-0.2,-88.4C17,-88,33.9,-83.6,47.1,-74.2Z" transform="translate(100 100)" />
                  </svg>
			</div>
        </div>
        
        <div class="flex flex-col-reverse flex-wrap sm:flex-row">
            <div class="w-full p-6 sm:w-1/2">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
  
                    <defs>
                        <pattern id="otherspattern" x="0" y="0" width="1" height="1">
                          <image height="100%" style="object-fit: cover" xlink:href="https://i0.wp.com/www.360precisioncleaning.com/wp-content/uploads/2018/05/deep-clean.jpeg?resize=700%2C467&ssl=1"/>
                        </pattern>
                    </defs>

                    
                    <path fill="url(#otherspattern)" d="M47.1,-74.2C60.3,-64.8,69.7,-50.5,74.7,-35.3C79.7,-20.2,80.3,-4.3,77.1,10.4C73.9,25,66.9,38.5,56.5,47.2C46.2,55.9,32.5,59.9,17.9,66.8C3.4,73.7,-12,83.5,-23.9,80.4C-35.7,77.3,-44,61.3,-53,47.7C-62,34.1,-71.8,22.9,-76.5,9.3C-81.1,-4.4,-80.7,-20.5,-75.8,-36.1C-71,-51.6,-61.6,-66.5,-48.2,-75.7C-34.9,-85,-17.4,-88.7,-0.2,-88.4C17,-88,33.9,-83.6,47.1,-74.2Z" transform="translate(100 100)" />
                  </svg>
			</div>	
			<div class="w-full p-6 mt-6 sm:w-1/2">
				<div class="align-middle">
					<h3 class="mb-3 text-3xl font-bold leading-none text-gray-800">Many More</h3>
					<p class="mb-8 text-gray-600">From cleaning your house to buying groceries! You can find all the professionals in {{ config("app.name") }} application.<br /><br />
					We know you love a little rest.
				</div>
			</div>

        </div>
	</div>
</section>
		
		
		

<section class="py-8 bg-white">
	
	<div class="container flex flex-wrap pt-4 pb-12 mx-auto">
	
		<h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">Meet The Professionals</h1>
		<div class="w-full mb-4">	
			<div class="w-64 h-1 py-0 mx-auto my-0 rounded-t opacity-25 gradient"></div>
		</div>
	
		@foreach ($ratings as $rating)
			<div class="flex flex-col flex-shrink w-full p-6 md:w-1/4">
				<div class="flex-col flex-1 py-6 overflow-hidden bg-white rounded-t rounded-b-none shadow">
					@if (!empty($rating->logo_id))
						<div class="flex items-center justify-center w-full pb-4">
							<img class="object-cover w-full h-36" src="{{ \App\Models\File::find($rating->logo_id)->file_url }}" alt="">
						</div>
					@endif
					<div class="w-full px-6 text-xl font-bold text-center text-gray-800">{{ $rating->name }}</div>
					<div class="w-full px-6 pt-6 text-xl text-center text-gray-800">Customer Rating</div>
					<div class="flex flex-row items-center justify-center py-5">
						<i class="{{ $rating->total_rating >= 1 ? 'text-yellow-300' : 'text-gray-300' }} fa fa-star fa-2x" aria-hidden="true"></i>
						<i class="{{ $rating->total_rating >= 2 ? 'text-yellow-300' : 'text-gray-300' }} fa fa-star fa-2x" aria-hidden="true"></i>
						<i class="{{ $rating->total_rating >= 3 ? 'text-yellow-300' : 'text-gray-300' }} fa fa-star fa-2x" aria-hidden="true"></i>
						<i class="{{ $rating->total_rating >= 4 ? 'text-yellow-300' : 'text-gray-300' }} fa fa-star fa-2x" aria-hidden="true"></i>
						<i class="{{ $rating->total_rating >= 5 ? 'text-yellow-300' : 'text-gray-300' }} fa fa-star fa-2x" aria-hidden="true"></i>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</section>


<!-- Change the colour #f8fafc to match the previous section colour -->
<svg class="wave-top" viewBox="0 0 1439 147" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g transform="translate(-1.000000, -14.000000)" fill-rule="nonzero">
        <g class="wave" fill="white">
            <path d="M1440,84 C1383.555,64.3 1342.555,51.3 1317,45 C1259.5,30.824 1206.707,25.526 1169,22 C1129.711,18.326 1044.426,18.475 980,22 C954.25,23.409 922.25,26.742 884,32 C845.122,37.787 818.455,42.121 804,45 C776.833,50.41 728.136,61.77 713,65 C660.023,76.309 621.544,87.729 584,94 C517.525,105.104 484.525,106.438 429,108 C379.49,106.484 342.823,104.484 319,102 C278.571,97.783 231.737,88.736 205,84 C154.629,75.076 86.296,57.743 0,32 L0,0 L1440,0 L1440,84 Z"></path>
        </g>
        <g transform="translate(1.000000, 15.000000)" fill="#FFFFFF">
            <g transform="translate(719.500000, 68.500000) rotate(-180.000000) translate(-719.500000, -68.500000) ">
                <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
                <path d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z" opacity="0.100000001"></path>
                <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" opacity="0.200000003"></path>
            </g>
        </g>
    </g>
</svg>

<section class="container py-6 mx-auto mb-12 text-center">
	<h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-white">Need to get work done?</h1>
	<div class="w-full mb-4">	
		<div class="w-1/6 h-1 py-0 mx-auto my-0 bg-white rounded-t opacity-25"></div>
	</div>

    <h3 class="my-4 text-3xl leading-tight">Download {{ config("app.name") }} now and hire professionals to complete it.</h3>
    
    <div class="flex items-center justify-center w-full">
        <button class="flex px-8 py-4 my-6 ml-0 mr-2 font-bold text-gray-800 bg-white rounded-full shadow-lg lg:ml-2 lg:mr-0 hover:underline">
            <svg class="h-5 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M19.665 16.811a10.316 10.316 0 0 1-1.021 1.837c-.537.767-.978 1.297-1.316 1.592c-.525.482-1.089.73-1.692.744c-.432 0-.954-.123-1.562-.373c-.61-.249-1.17-.371-1.683-.371c-.537 0-1.113.122-1.73.371c-.616.25-1.114.381-1.495.393c-.577.025-1.154-.229-1.729-.764c-.367-.32-.826-.87-1.377-1.648c-.59-.829-1.075-1.794-1.455-2.891c-.407-1.187-.611-2.335-.611-3.447c0-1.273.275-2.372.826-3.292a4.857 4.857 0 0 1 1.73-1.751a4.65 4.65 0 0 1 2.34-.662c.46 0 1.063.142 1.81.422s1.227.422 1.436.422c.158 0 .689-.167 1.593-.498c.853-.307 1.573-.434 2.163-.384c1.6.129 2.801.759 3.6 1.895c-1.43.867-2.137 2.08-2.123 3.637c.012 1.213.453 2.222 1.317 3.023a4.33 4.33 0 0 0 1.315.863c-.106.307-.218.6-.336.882zM15.998 2.38c0 .95-.348 1.838-1.039 2.659c-.836.976-1.846 1.541-2.941 1.452a2.955 2.955 0 0 1-.021-.36c0-.913.396-1.889 1.103-2.688c.352-.404.8-.741 1.343-1.009c.542-.264 1.054-.41 1.536-.435c.013.128.019.255.019.381z" fill="black"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg>
            <span>IOS</span>
        </button>
        <button class="flex px-8 py-4 my-6 ml-0 mr-2 font-bold text-gray-800 bg-white rounded-full shadow-lg lg:ml-2 lg:mr-0 hover:underline">
            <svg class="h-5 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 301"><path d="M78.389.858a8.824 8.824 0 0 0-4.19 1.089c-4.218 2.338-5.765 7.757-3.428 11.972l9.523 17.196C57.35 45.31 42.147 69.558 42.147 97.233v5.142c-4.407-5.07-10.884-8.271-18.121-8.271C10.766 94.104 0 104.87 0 118.129v74.009c0 13.258 10.767 24.025 24.026 24.025c7.237 0 13.714-3.202 18.12-8.272v10.367c0 13.977 11.437 25.413 25.414 25.413h6.448v32.923c0 13.26 10.767 24.026 24.026 24.026s24.025-10.767 24.025-24.026v-32.923h11.156v32.923c0 13.26 10.767 24.026 24.026 24.026s24.025-10.767 24.025-24.026v-32.923h6.449c13.976 0 25.413-11.436 25.413-25.413v-10.367c4.406 5.07 10.884 8.272 18.121 8.272c13.259 0 24.025-10.767 24.025-24.025v-74.009c0-13.259-10.766-24.025-24.025-24.025c-7.237 0-13.715 3.201-18.121 8.271v-4.272v-.245c.002-.26 0-.468 0-.625c0-27.67-15.238-51.894-38.174-66.09l9.55-17.224c2.336-4.215.79-9.634-3.428-11.972a8.824 8.824 0 0 0-4.19-1.089c-3.115-.03-6.172 1.612-7.782 4.517l-9.986 18.04c-9.764-3.603-20.388-5.578-31.48-5.578c-11.082 0-21.726 1.954-31.482 5.55L86.171 5.375C84.56 2.47 81.504.83 78.389.858z" fill="#FFF"/><path d="M24.026 100.362c-9.894 0-17.767 7.873-17.767 17.767v74.009c0 9.894 7.873 17.767 17.767 17.767c9.894 0 17.768-7.873 17.768-17.767v-74.009c0-9.894-7.874-17.767-17.768-17.767zm207.224 0c-9.895 0-17.768 7.873-17.768 17.767v74.009c0 9.894 7.873 17.767 17.768 17.767c9.894 0 17.767-7.873 17.767-17.767v-74.009c0-9.894-7.873-17.767-17.767-17.767z" fill="#A4C639"/><path d="M98.034 184.818c-9.894 0-17.768 7.873-17.768 17.768v74.008c0 9.894 7.874 17.767 17.768 17.767c9.894 0 17.767-7.873 17.767-17.767v-74.008c0-9.895-7.873-17.768-17.767-17.768zm59.207 0c-9.895 0-17.768 7.873-17.768 17.768v74.008c0 9.894 7.873 17.767 17.768 17.767c9.894 0 17.767-7.873 17.767-17.767v-74.008c0-9.895-7.873-17.768-17.767-17.768z" fill="#A4C639"/><path d="M78.443 7.117a2.47 2.47 0 0 0-1.197.326c-1.267.702-1.683 2.158-.98 3.428l12.517 22.611c-24.08 12.53-40.346 36.341-40.378 63.669H206.87c-.033-27.328-16.298-51.14-40.378-63.669l12.516-22.61c.704-1.27.287-2.727-.98-3.429a2.467 2.467 0 0 0-1.197-.326c-.9-.01-1.751.44-2.231 1.306l-12.68 22.855c-10.372-4.6-22.006-7.183-34.283-7.183c-12.277 0-23.91 2.582-34.283 7.183L80.674 8.423a2.486 2.486 0 0 0-2.23-1.306zm-30.038 96.292v114.85a19.113 19.113 0 0 0 19.155 19.154h120.155a19.113 19.113 0 0 0 19.155-19.155V103.41H48.405z" fill="#A4C639"/><path d="M91.068 54.923c-3.617 0-6.612 2.994-6.612 6.611c0 3.618 2.995 6.612 6.612 6.612c3.618 0 6.612-2.994 6.612-6.612c0-3.617-2.994-6.611-6.612-6.611zm73.138 0c-3.618 0-6.612 2.994-6.612 6.611c0 3.618 2.994 6.612 6.612 6.612c3.617 0 6.612-2.994 6.612-6.612c0-3.617-2.995-6.611-6.612-6.611z" fill="#FFF"/><rect x="0" y="0" width="256" height="301" fill="rgba(0, 0, 0, 0)" /></svg>
            <span>Android</span>
        </button>
    </div>
</section>


  <!-- jQuery if you need it
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  -->
<script>
	var navMenuDiv = document.getElementById("nav-content");
	var navMenu = document.getElementById("nav-toggle");
	
	document.onclick = check;
	function check(e){
	  var target = (e && e.target) || (event && event.srcElement);
	  
	  //Nav Menu
	  if (!checkParent(target, navMenuDiv)) {
		// click NOT on the menu
		if (checkParent(target, navMenu)) {
		  // click on the link
		  if (navMenuDiv.classList.contains("hidden")) {
			navMenuDiv.classList.remove("hidden");
		  } else {navMenuDiv.classList.add("hidden");}
		} else {
		  // click both outside link and outside menu, hide menu
		  navMenuDiv.classList.add("hidden");
		}
	  }
	  
	}
	function checkParent(t, elm) {
	  while(t.parentNode) {
		if( t == elm ) {return true;}
		t = t.parentNode;
	  }
	  return false;
	}
</script>


</body>

</html>