@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">

    @include('common.errors')
    
    <form action="{{ url('/ok') }}" method="POST">

        <!-- item_name -->
        <div class="form-group">
           <P>相手情報</P>
           <label for="item_name">相手_代表者</label>
           <lavel type="text" id="item_name" name="item_name" class="form-control" value="">
        <?php echo $opponent->user_id ?>
        <?php echo $user->select()->where('id','=',$opponent->user_id)->value('name')?>
      
        </div>
        <!--/ item_name -->
        
        <!-- item_number -->
        <div class="form-group">
           <label for="item_number">相手の友人</label>
        <lavel type="text" id="item_number" name="item_number" class="form-control" value="{{$opponent->friend_id }}">
        <?php echo $opponent->friend_id ?>
        <?php echo $user->select()->where('id','=',$opponent->friend_id)->value('name')?>

        </div>
        <!--/ item_number -->

        <!-- item_amount -->
        <div class="form-group">
           <label for="item_amount">場所</label>
        <lavel type="text" id="item_amount" name="item_amount" class="form-control" value="{{ $opponent->location }}">
         <?php echo $opponent->location ?>
        </div>
        <!--/ item_amount -->
        
        <!-- published -->
        <div class="form-group">
           <label for="published">登録時間</label>
            <lavel type="datetime" id="published" name="published" class="form-control" value="{{ $opponent->created_at }}"/>
         <?php echo $opponent->created_at ?>
        </div>
        <!--/ published -->
        
        
        <!-- Saveボタン/Backボタン -->
        <div class="well well-sm">
            <p>合流しますか？</p>
            
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
    
     <form action="{{ url('/ng') }}" method="POST">
             {{ csrf_field() }}
                                
              <button type="submit" class="btn btn-danger">
                <i class="glyphicon glyphicon-trash"></i> NG
              </button>
     </form>
          
    
        
    </div>
</div>
@endsection