<x-layout>
	@slot('title')
		Вакансии
	@endslot
	<div class="container mt-4">
		@if(session()->get('success'))
			<div class="alert alert-success alert-dismissible fade show">
			  {{ session()->get('success') }}  
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif

		@auth
		  <div class="m-2">
		  	<a href="{{ route('vacancies.recommended') }}">Рекомендації для вас {{ Auth::user()->name }}</a>
		  </div>
		@endauth
		<div id="filter">
			<button type="button" class="btn border-primary rounded my-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
			  Филтрi
		    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-left" viewBox="0 0 16 16">
			  <path d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
			</svg>
			</button>

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body">
						    <form action="{{ route('home') }}" method="get">
						        <div class="mb-1 p-2">
						            <label for="city" class="form-label">Мiсто</label>
						            <input type="text" class="form-control" name="city" @if(isset($_GET['city'])) value="{{$_GET['city']}}" @endif>
						        </div>
						        
						        <div class="mb-1 p-2">
						            <label for="category" class="form-label">Категорія</label>
						            <select class="form-select" aria-label="Default select example" name="category_id">
						                <option value="0">Всi</option>
						                @foreach($categories as $category)
						                    <option value="{{ $category->id }}" @if(isset($_GET['category_id']) and $_GET['category_id'] == $category->id)  selected @endif>{{ $category->title }}</option>
						                @endforeach
						            </select>
						        </div>

						         <div class="mb-1 p-2">
						            <label for="salary" class="form-label">Зарплата</label>
						            <select class="form-select" aria-label="Default select example" name="salary">
						              <option value="0">Всi</option>
						              <option value="10000" @if(isset($_GET['salary']) and $_GET['salary'] == '10000') selected @endif>Вiд 10 000 грн</option>
						              <option value="15000" @if(isset($_GET['salary']) and $_GET['salary'] == '15000') selected @endif>Вiд 15 000 грн</option>
						              <option value="20000" @if(isset($_GET['salary']) and $_GET['salary'] == '20000') selected @endif>Вiд 20000 грн</option>
						              <option value="30000" @if(isset($_GET['salary']) and $_GET['salary'] == '30000') selected @endif>Вiд 30000 грн</option>
						              <option value="40000" @if(isset($_GET['salary']) and $_GET['salary'] == '40000') selected @endif>Вiд 40000 грн</option>
						            </select>
						        </div>
						          
						        <div class="mb-1 p-2">
						            <label for="experience" class="form-label">Досвiд роботи</label>
						            <select class="form-select" aria-label="Default select example" name="experience">
						              <option value="0">Всi</option>
						              <option value="1" @if(isset($_GET['experience']) and $_GET['experience'] == '1') selected @endif>1 року</option>
						              <option value="2" @if(isset($_GET['experience']) and $_GET['experience'] == '2') selected @endif>2 рокiв</option>
						              <option value="3" @if(isset($_GET['experience']) and $_GET['experience'] == '3') selected @endif>3 рокiв</option>
						            </select>
						        </div>

						        <div class="text-center mb-1">
						            <a href="{{ route('home') }}" class="btn">Скинути</a>
						            <input type="submit" class="btn" value="Застосувати">
						        </div> 

						    </form>
						</div>
					</div>
				</div>
			</div>
		</div>  

		@foreach($vacancies as $vacancy)
			<div class="vacancy mb-1 rounded p-3">
				<h4>
					<a href="{{ $vacancy->link }}">
						{{ $vacancy->title }}
					</a>
				</h4>

				@if($vacancy->salary !== null) 
					<div class="salary">
						<i class="bi bi-cash-coin"></i>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="tomato" class="bi bi-cash-coin" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
						  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
						  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
						  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
						</svg>
						<span>{{ $vacancy->salary }} грн</span>
					</div>
				@endif

				<div class="location">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="tomato" class="bi bi-geo-alt" viewBox="0 0 16 16">
					  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
					  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
					</svg>
					<span>{{ $vacancy->city }}</span>
				</div>

				<div class="location">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="tomato" class="bi bi-buildings" viewBox="0 0 16 16">
					  <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022ZM6 8.694 1 10.36V15h5V8.694ZM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15Z"/>
					  <path d="M2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-2 2h1v1H2v-1Zm2 0h1v1H4v-1Zm4-4h1v1H8V9Zm2 0h1v1h-1V9Zm-2 2h1v1H8v-1Zm2 0h1v1h-1v-1Zm2-2h1v1h-1V9Zm0 2h1v1h-1v-1ZM8 7h1v1H8V7Zm2 0h1v1h-1V7Zm2 0h1v1h-1V7ZM8 5h1v1H8V5Zm2 0h1v1h-1V5Zm2 0h1v1h-1V5Zm0-2h1v1h-1V3Z"/>
					</svg>
					<span>{{ $vacancy->company_name }}</span>
				</div>

				@if($vacancy->experience !== null)
					<div class="experience">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="tomato" class="bi bi-bag-check" viewBox="0 0 16 16">
						  <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
						  <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
						</svg>
						<span>від {{ $vacancy->experience }} років/року досвіду</span>
					</div>
				@endif

			</div>
		@endforeach

		{{-- <div>
							<form action="{{ route('follow') }}" method="POST">
								@csrf
								<input type="hidden" name="city" @if(isset($_GET['city'])) value="{{$_GET['city']}}" @endif>
								<input type="hidden" name="salary" @if(isset($_GET['salary'])) value="{{$_GET['salary']}}" @endif>
								<input type="hidden" name="experience" @if(isset($_GET['experience'])) value="{{$_GET['experience']}}" @endif>
								<input type="hidden" name="category_id" @if(isset($_GET['category_id'])) value="{{$_GET['category_id']}}" @endif>
								<input type="submit" value="Подписатся на вакансии и получить по email" class="link-primary">
							</form>
						</div> --}}

		<div class="d-flex justify-content-center m-5 px-4">
			{{ $vacancies->links() }}
		</div>
	</div>
</x-layout>