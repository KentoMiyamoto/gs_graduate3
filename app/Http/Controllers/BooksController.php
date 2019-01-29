<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

// use App\Book;
use App\entry;
use App\match;
use Validator;
use Auth;


class BooksController extends Controller
{
    
    public function index()
    {
    
        
$entries	=	entry::where('user_id',Auth::user()->id)	
->orderBy('created_at',	'desc')
->paginate(3);


$user = Auth::user();

         return view('portal', [
            'entries' => $entries
         ],['user' => $user]);
         
         
    }
    
    
    
    
        public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function update (Request $request)
    {
          $validator = Validator::make($request->all(), [
        'id'=>'required',
        'item_name' => 'required|min:3|max:255',
        'item_number' => 'required|min:1|max:3',
        'item_amount' => 'required|max:6',
        'published' => 'required',
        
    ]);


    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    //以下に登録処理を記述（Eloquentモデル）
    // Eloquent モデル
$books = Book::where('user_id',Auth::user()->id)->find($request->id);
$books->item_name = $request->item_name;
$books->item_number =  $request->item_number;
$books->item_amount =  $request->item_amount;
$books->published =  $request->published;
$books->save(); 
return redirect('/');

    
    }
 
    

  public function store (Request $request)
      
    {
      $validator = Validator::make($request->all(), [
        'item_name' => 'required|min:3|max:255',
        'item_number' => 'required|min:1|max:3',
        'item_amount' => 'required|max:6',
        'published' => 'required',
        
    ]);

    //バリデーション:エラー 
    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }
    //以下に登録処理を記述（Eloquentモデル）
    // Eloquent モデル
$books = new Book;
$books->user_id = Auth::user()->id;
$books->item_name = $request->item_name;
$books->item_number = '1';
$books->item_amount = '1000';
$books->published = '2017-03-07 00:00:00';
$books->save(); 
return redirect('/');
    }

    


  public function edit ($book_id)
      
    {
    $books = Book::where('user_id',Auth::user()->id)->find($book_id);    
    return view('booksedit', [
        'book' => $books
        ]);
        
    }
    
    
    
  public function destroy (entry $entry)
      
    {
    $entry->delete();
    return redirect('/');
        
    }
    


  public function entry(Request $request)
    {

$entries = new entry;
$entries->user_id = Auth::user()->id;
$entries->friend_id = $request->friend_id;
$entries->gender = $request->gender;
$entries->location = $request->location;
// $entries->item_number = '1';
// $entries->item_amount = '1000';
// $entries->published = '2017-03-07 00:00:00';
$entries->save(); 
return redirect('/');




    }


  public function matching ()
      
    {
        
$myself =  Auth::user()->id;

$myentryid = entry::select()
             ->where('user_id','=',$myself) 
             ->value('id');

$mygender = entry::select()
             ->where('user_id','=',$myself) 
             ->value('gender');

$check1 = match::where('men_entry_id','=',$myentryid)->value('id');
$check2 = match::where('women_entry_id','=',$myentryid)->value('id');

$flgupdate = entry::where('user_id','=',$myself);
$flgupdate->update(['finish_flg' => 1]);


// 登録がなければ
if($check1 == 0){
    
    if($check2 == 0){
    
    
            $mygender = entry::select()
             ->where('user_id','=',$myself) 
             ->value('gender');



            // 登録
            $matches = new match;

            if($mygender == 1){

            $matches->men_entry_id = $myentryid;
            $matches->women_entry_id = entry::select()
                    -> where('user_id','<>',$myself)
                    -> where('gender','<>',$mygender)
                    -> where('finish_flg','=',0)
                    -> value('id');
            $matches->save(); 


            }else {
            $matches->women_entry_id = $myentryid;
            $matches->men_entry_id = entry::select()
                    -> where('user_id','<>',$myself) 
                    -> where('gender','<>',$mygender)
                    -> where('finish_flg','=',0)
                    -> value('id');
            $matches->save(); 

            }

                // フラグUPDATE
                if($mygender == 1){
                $oppoid4 = match::select()
                ->where('men_entry_id','=',$myentryid) 
                ->value('women_entry_id');
             
                $flgupdate2 = entry::where('id','=',$oppoid4);
                $flgupdate2->update(['finish_flg' => 1]);

                }else {
                $oppoid4 = match::select()
                ->where('women_entry_id','=',$myentryid) 
                ->value('men_entry_id');

                $flgupdate2 = entry::where('id','=',$oppoid4);
                $flgupdate2->update(['finish_flg' => 1]);
                };



        $opponent = entry::select()
        -> where('id','=',$oppoid4) 
        -> first();
    
        $user = Auth::user();
    
        return view('matching',['opponent'=>$opponent],['user'=>$user]);


    }else
    //  women登録があるとき


    $oppoid2 = match::where('women_entry_id','=',$myentryid)->value('men_entry_id');
    $opponent = entry::select()
         -> where('id','=',$oppoid2)
         -> first();
    

    $user = Auth::user();

    return view('matching',['opponent'=>$opponent],['user'=>$user]);


}else

    $oppoid1 = match::where('men_entry_id','=',$myentryid)->value('women_entry_id');
    $opponent = entry::select()
         -> where('id','=',$oppoid1) 
         -> first();

    $user = Auth::user();

    return view('matching',['opponent'=>$opponent],['user'=>$user]);

    }
    
    
    
public function ok ()
      {
          $myself =  Auth::user()->id;      
        
         $myentryid = entry::select()
                     ->where('user_id','=',$myself) 
                     ->value('id');
         
         $mygender = entry::select()
                     ->where('user_id','=',$myself) 
                     ->value('gender');
         
             
        if($mygender==1){             
                 
        $menresult = match::where('men_entry_id','=',$myentryid);
        $menresult->update(['men_result' => 1]);
        
        $womenresult = match::where('men_entry_id','=',$myentryid)
                    ->value('women_result');


            if($womenresult == 1){
        
        
            $oppoid1 = match::where('men_entry_id','=',$myentryid)->value('women_entry_id');
            $opponent = entry::select()
            -> where('id','=',$oppoid1) 
            -> first();
        
            return view('goryu',['opponent'=>$opponent]);
            }
        
            
            }else{
            $womenresult = match::where('women_entry_id','=',$myentryid);
            $womenresult->update(['women_result' => 1]);
        
            $menresult = match::where('women_entry_id','=',$myentryid)
                    ->value('men_result');
        
                if($menresult == 1){
        
                $oppoid1 = match::where('women_entry_id','=',$myentryid)->value('men_entry_id');
                $opponent = entry::select()
                -> where('id','=',$oppoid1) 
                -> first();
        
                return view('goryu',['opponent'=>$opponent]);
                }    
        
        }
        
        return redirect('/');
        
      }




public function ng ()
      {
          $myself =  Auth::user()->id;      
        
    
          $myentryid = entry::select()
                     ->where('user_id','=',$myself) 
                     ->value('id');
         
         $mygender = entry::select()
             ->where('user_id','=',$myself) 
             ->value('gender');
             
                 
        if($mygender==1){             
                 
        $menresult = match::where('men_entry_id','=',$myentryid);
        $menresult->update(['men_result' => 2]);
        
            
        }else{
        $menresult = match::where('women_entry_id','=',$myentryid);
        $menresult->update(['women_result' => 2]);
        }
        
        
        return redirect('/');
        
         
        
      }



    
}




