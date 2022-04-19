@php
  use App\SM\SM;
  $sliders = SM::smGetThemeOption("slider_images");
@endphp
@php
  $entry_date = date('m/d/Y');
  $date = date('M d, Y');
  $date = strtotime($date);
  $date = strtotime("+1 day", $date);
  $exit_date = date('m/d/Y', $date);
  $date_range = $entry_date.' - '.$exit_date;
  if(Session::has('entry_date') && Session::has('exit_date'))
  {
    $entry_date = Session::get('entry_date');
    $entry_date = date_create($entry_date);
    $entry_date = date_format($entry_date,"m/d/Y");
    $exit_date = Session::get('exit_date');
    $exit_date = date_create($exit_date);
    $exit_date = date_format($exit_date,"m/d/Y");
    $date_range = $entry_date.' - '.$exit_date;
  }
  if(Session::has('adult')){
    $adult = Session::get('adult');
  }else {
    $adult=1;
  }
  if(Session::has('children')){
    $children = Session::get('children');
  }else{
    $children=1;
  }
@endphp
<div class="main-slider-section">
  <div class="main-slider">
    @if(!empty($sliders))
      @foreach($sliders as $slider)
      @if($slider)
        @php 
          $slider1 = SM::sm_get_the_src($slider["slider_image"],1920,750);
        @endphp
        <div>
          <div class="slider-img">
            <img src="{{ $slider1 }}" name="{{ $slider1 }}" alt="{{ $slider["slider_image"] }}">    
          </div>
        </div>
        @endif
      @endforeach
    @else 
      <div>
        <div class="slider-img">
          <img  height="800" src="{{ URL::to('/') }}/assets/image/slider/slider_default_img.jpg" alt="logo">
         
        </div>
      </div>
    @endif
  </div>

  <div class="slider-contant">
  <form  action="{{ route('room_list') }}">
      <input type="text" id="daterange" name="daterange" value="{{ $date_range }}" />
      <select name="adult" class="select2">
        <option value="1" {{ $adult === '1' ? 'selected' : '' }}> 1 Adult</option>
        <option value="2" {{ $adult === '2' ? 'selected' : '' }}> 2 Adult</option>
        <option value="3" {{ $adult === '3' ? 'selected' : '' }}> 3 Adult</option>
        <option value="4" {{ $adult === '4' ? 'selected' : '' }}> 4 Adult</option>
        <option value="5" {{ $adult === '5' ? 'selected' : '' }}> 5 Adult</option>
        <option value="6" {{ $adult === '6' ? 'selected' : '' }}> 6 Adult</option>
        <option value="7" {{ $adult === '7' ? 'selected' : '' }}> 7 Adult</option>
        <option value="8" {{ $adult === '8' ? 'selected' : '' }}> 8 Adult</option>
        <option value="9" {{ $adult === '9' ? 'selected' : '' }}> 9 Adult</option>
        <option value="10" {{ $adult === '10' ? 'selected' : '' }}> 10 Adult</option>
      </select>
      <select name="children" class="select2" >
        <option value="0" {{ $children === '0' ? 'selected' : '' }}> 0 Children</option>
        <option value="1" {{ $children === '1' ? 'selected' : '' }}> 1 Children</option>
        <option value="2" {{ $children === '2' ? 'selected' : '' }}> 2 Children</option>
        <option value="3" {{ $children === '3' ? 'selected' : '' }}> 3 Children</option>
        <option value="4" {{ $children === '4' ? 'selected' : '' }}> 4 Children</option>
        <option value="5" {{ $children === '5' ? 'selected' : '' }}> 5 Children</option>
        <option value="6" {{ $children === '6' ? 'selected' : '' }}> 6 Children</option>
        <option value="7" {{ $children === '7' ? 'selected' : '' }}> 7 Children</option>
        <option value="8" {{ $children === '8' ? 'selected' : '' }}> 8 Children</option>
        <option value="9" {{ $children === '9' ? 'selected' : '' }}> 9 Children</option>
        <option value="10" {{ $children === '10' ? 'selected' : '' }}> 10 Children</option>
      </select>
      <button type="submit"><i class="fa fa-search"></i>Search</button>
    </form>
    
  </div>
  <div id="particles-js"></div>
</div>
