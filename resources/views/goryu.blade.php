@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">

    @include('common.errors')
    
    <form action="{{ url('/') }}" method="POST">

        <!-- item_name -->
       
        <!-- item_amount -->
        <div class="form-group">
         <label for="item_amount">場所</label>
        <lavel type="text" id="item_amount" name="item_amount" class="form-control" value="$opponent->location"."で合流しましょう">    
 　　 　 <?php echo $opponent->location."で合流しましょう"?>
 　　 　 </div>
        <!--/ item_amount -->
        
        
        
        <!-- Saveボタン/Backボタン -->
        <div class="well well-sm">

            
            <button type="submit" class="btn btn-primary">OK
            </button>
  
          
           
            <a class="btn btn-link pull-right" href="{{ url('/') }}">
                <i class="glyphicon glyphicon-backward"></i>  Back
            </a>
        
    </div>    
        
        <!--/ Saveボタン/Backボタン -->
         
         <!-- id値を送信 -->
         <input type="hidden" name="id" value="" />
         <!--/ id値を送信 -->
         
         <!-- CSRF -->
         {{ csrf_field() }}
         <!--/ CSRF -->
         
    </form>
    
        
    </div>
</div>
@endsection