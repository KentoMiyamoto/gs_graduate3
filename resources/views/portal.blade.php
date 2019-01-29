<!-- resources/views/books.blade.php -->

@extends('layouts.app')
@section('content')

    <div class="panel-body">
    
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
         <!-- バリデーションエラーの表示に使用-->

         <!-- 本登録フォーム -->
        <form action="{{ url('portal') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
             <!-- 本のタイトル -->
             <div class="form-group">
                <div class="col-sm-6">
                
                <p>必要事項を入力してエントリーしてください</p>
                 <label for="friend_id" class="col-sm-3 control-label">友人ID</label>
                 <input type="text" name="friend_id" id="friend_id" class="form-control">

                 <label for="gender" class="col-sm-3 control-label">性別(男性:1,女性:2)</label>
                 <input type="text" name="gender" id="gender" class="form-control">

                 <label for="location" class="col-sm-3 control-label">場所</label>
                 <input type="text" name="location" id="location" class="form-control">
               
               </div>          

             </div>        
    

             <!-- 本 登録ボタン -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="glyphicon glyphicon-plus"></i> entry
                    </button>
                </div>
            </div>
            
            
        </form>
        <!-- 本登録フォーム -->


     <!-- 現在 本 -->
     @if (count($entries) > 0)
         <div class="panel panel-default">
                <div class="panel-heading"> 
                    エントリー状況
                </div>
                <div class="panel-body">
                <table class="table table-striped task-table">
                    <!-- テーブルヘッダ -->
                    <thead>
                        <th>エントリー中</th>
                        <th>&nbsp;</th>
                    </thead>
                    <!-- テーブル本体 -->
                    <tbody>
                         @foreach ($entries as $entry)

                            <tr>
                                 <!--本タイトル -->

                                <td class="table-text">
                                   <!--<div>{{ $entry->user_id }}:{{ $user->name}}</div>-->
                                  <?php echo $user->select()->where('id','=',$entry->user_id)->value('name')?>
                                    
                                </td>
                                
                                <td class="table-text">
                                    <!--<div>{{ $entry->friend_id }}</div>-->
                                  <?php echo $user->select()->where('id','=',$entry->friend_id)->value('name')?>

                                </td>
                                
                                
                                <td class="table-text">
                                    <div>{{ $entry->location }}</div>
                                </td>
                                
                                
                                <td class="table-text">
                                    <div>{{ $entry->created_at }}</div>
                                </td>
                                
                            
                            
                            
                              <!-- : 更新ボタン -->
                                <td>
                                    <form action="{{ url('matching/'.$entry->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-primary">
                                            <i class="glyphicon glyphicon-pencil"></i> table share
                                        </button>
                                    </form>
                                </td>
                            
                            
                            
                                <!-- エントリー: 削除ボタン -->
                                <td>
                                    <form action="{{ url('entry/delete/'.$entry->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger">
                                            <i class="glyphicon glyphicon-trash"></i> キャンセル
                                        </button>
                                    </form>
                                </td>
                               
                
                            </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
         </div>
     @endif
     
       
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            {{ $entries->links()}}
            </div>
        </div>

     </div>

     <!-- Book: 既に登録されてる本のリスト -->
@endsection

