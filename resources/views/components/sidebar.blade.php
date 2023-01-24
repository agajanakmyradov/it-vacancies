<div class="sidebar align-self-start mt-5 me-2">    
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