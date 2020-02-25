<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use DateTime;
use Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //$allcount=DB::table('wingg_app_post')->count();

      // $user_id=$request->session()->get('chat_admin')->id;
      //   $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
      //   ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
      //   ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
      //   ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
      //   ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
      //   ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
      //   ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->paginate(10);
      //  $usercount=$posts->count();
        return view('admin.news');
    }

    public function showPosts(Request $request)
    {
        $date = $_GET['date'];
      //dd($date);
      if ($date !="") {
        $getcurrentday = date("Y-m-d h:i:s");
        if ($date == "today") {
          $gettoday = date("Y-m-d");
          // dd($gettoday);
        }
        if ($date == "1 day") {
          $get_date = date('Y-m-d h:i:s', strtotime('-1 day', strtotime($getcurrentday)));
        }elseif ($date == '1 week') {
          $get_date = date('Y-m-d h:i:s', strtotime('-1 week', strtotime($getcurrentday)));
        }elseif ($date == '15 days') {
          $get_date = date('Y-m-d h:i:s', strtotime('-15 days', strtotime($getcurrentday)));
        }elseif ($date == '1 month') {
          $get_date = date('Y-m-d h:i:s', strtotime('-1 month', strtotime($getcurrentday)));
        }elseif ($date == '6 month') {
          $get_date = date('Y-m-d h:i:s', strtotime('-6 month', strtotime($getcurrentday)));
        }elseif ($date == '1 year') {
          $get_date = date('Y-m-d h:i:s', strtotime('-1 year', strtotime($getcurrentday)));

        }
      }
      // dd($get_date);
$user_id=$request->session()->get('chat_admin')->id;
$company_id=$request->session()->get('chat_admin')->company_id;
      // dd($get_date .'/'. $getcurrentday);
       $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
       ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
       ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
       ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
       ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
       ->where('wingg_app_post.company_id','=',$company_id);

       if ($date =='today' && $gettoday !='') {
         // $gettoday ='2020-02-13';
         $posts->where('wingg_app_post.created_at','like','%'.$gettoday.'%');
       }elseif ($get_date != '' && $getcurrentday != '') {
         $posts->whereBetween('wingg_app_post.created_at',[$get_date, $getcurrentday]);
       }
       $posts=$posts->orderby('wingg_app_post.created_at','desc')->paginate(20);
    //  dd($posts);

         $posts2=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
         ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
         ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
         ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
         ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
         ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
         ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->get();
        $totalcount=$posts2->count();
       $total = count($posts->items());
       //dd($totalcount);
       $output='';
       $x=[];
       $output .= '<table class="table">';
       $output .= ' <thead>';
       $output .= '<th colspan="2"></th>';
       $output .= '<th colspan="2">Title</th>';
       $output .= '<th colspan="">Created at</th>';
       $output .= '<th colspan="3">Team</th>';
       $output .= '<th colspan="3">Roles</th>';
       $output .= '<th colspan="3">Targeted Audience</th>';
       $output .= '<th colspan="3">Likes</th>';
       $output .= '<th colspan="3">Dislike</th>';
       $output .= '<th colspan="3">blank_field</th>';
       $output .= '<th colspan="3">blank_field</th>';

       $output .= '</thead>';
       $output .= '<tbody >';
       if(!$posts->isEmpty())
       {
           foreach($posts as $post)
           {
             $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
             if($post->cover_image){
                 $cover_image=$post->cover_image;
             }else{
               $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
             }
           $text_url = url('dashboard/edit-post-text/'.$post->id);
           $image_url = url('dashboard/edit-post-image/'.$post->id);
           $link_url = url('dashboard/edit-post-link/'.$post->id);
           $delete_url = url('dashboard/deletepost/'.$post->id);
           // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

           $output .= '<tr>';
             $output .= '<td class="action-btn" style="width: 9%;">';
               if($post->content){
               $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
               }elseif($post->image_url){
               $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
               }else{
               $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
               }
               $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
               $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
             $output .= '</td>';
             $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
               $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
             $output .= '</td>';
             $output .= '<td colspan="2"> '.$post->created_at.'</td>';
             $output .= '<td colspan="3"> '.$post->t_name.'</td>';
             $output .= '<td colspan="3"> '.$post->p_name.'</td>';
             $output .= '<td colspan="3"> 2812</td>';
             $output .= '<td colspan="3"> '.$post->likes.'</td>';
             $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
             $output .= '<td colspan="3"> -</td>';
             $output .= '<td colspan="3"> -</td>';
           $output .= '</tr>';
           }
           $output.='</tbody>';
           $output.='  </table>';
           $output.=$posts->render();
           // dd($output);

       }
       $x = array(
         'output' => $output,
         'total' => $total,
         'totalcount' => $totalcount,

     );
       echo json_encode($x);
      // dd($posts);
    //   return view('admin.posts',compact('posts'));
    }
    public function showdatepage(Request $request)
    {

    return view('admin.posts',compact('posts'));
 }


    public function store(Request $request)
    {
        if($request->isMethod('post')){
           //dd($request->input());
        $company_id=$request->session()->get('chat_admin')->company_id;
            $input['title']=$request->input('post_title');
            $input['content']=$request->input('post_description');
            $input['company_id']=$company_id;
            $input['dislikes']=0;
            $input['likes']=0;
            $input['created_at']=  date('Y-m-d H:i:s');
            $input['updated_at']=  date('Y-m-d H:i:s');
             $image = $request->file('cover_image');
//dd($image);
            if ($image !="") {
            $profilePicture = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('cover/images');
            $image->move($destinationPath, $profilePicture);
            $imagepath='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePicture;
            $input['cover_image']=$imagepath;
            }

           $post_id=DB::table('wingg_app_post')->insertGetId( $input);

           $team['team_id']=$request->input('team');
           $team['post_id']=$post_id;
           $wingg_app_postteam=DB::table('wingg_app_postteam')->insertGetId($team);

           $position['position_id']=$request->input('role');
           $position['post_id']=$post_id;
           $wingg_app_postposition=DB::table('wingg_app_postposition')->insertGetId($position);
           $request->session()->flash('post', 'Post Create Sussessfully');
            return redirect('/dashboard');
        }
       return view('admin.add-post');
    }

    // Edit text Post
    public function editPost(Request $request, $id)
    {
      // dd($id);
      if($request->isMethod('post')){
        // dd($request->all());
        $company_id=$request->session()->get('chat_admin')->company_id;
        $input['title'] = $request->input('post_title');
        $input['content'] = $request->input('post_description');
        $input['company_id']=$company_id;
        $input['dislikes']=0;
        $input['likes']=0;
        $input['created_at']=  date('Y-m-d H:i:s');
        $input['updated_at']=  date('Y-m-d H:i:s');

        $image = $request->file('cover_image');
        if ($image !="") {
        $profilePicture = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('cover/images');
        $image->move($destinationPath, $profilePicture);
        $imagepath='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePicture;
        $input['cover_image']=$imagepath;
        }
        // dd($input);
        DB::table('wingg_app_post')->where('id', $id)->update($input);

        $wingg_app_postteam=DB::table('wingg_app_postteam')->where('post_id', $id)->first();


        $team['team_id'] = $request->input('team');
        DB::table('wingg_app_postteam')->where('id', $wingg_app_postteam->id)->update($team);

        $wingg_app_postposition=DB::table('wingg_app_postposition')->where('post_id', $id)->first();

        $position['position_id']=$request->input('role');
        DB::table('wingg_app_postposition')->where('id', $wingg_app_postposition->id)->update($position);

        $request->session()->flash('post', 'Post updated Sussessfully');
        return redirect('/dashboard');
      }

      $post=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
      ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
      ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
      ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
      ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
      ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
      ->where('wingg_app_postteam.post_id','=',$id)->first();
      //dd($post);
      return view('admin.edit_post_text', compact('post'));
    }

    // Edit Image Post
    public function editPostImage(Request $request, $id)
    {
        // dd($request->all());
      if($request->isMethod('post')){
        // dd($request->all());
        $company_id=$request->session()->get('chat_admin')->company_id;
        if ($request->input('post_title') !="") {
          $input['title']=$request->input('post_title');
        }
        $input['content']=$request->input('post_description');
        $input['company_id']=$company_id;
        $input['dislikes']=0;
        $input['likes']=0;
        $input['created_at']=  date('Y-m-d H:i:s');
        $input['updated_at']=  date('Y-m-d H:i:s');
         $image = $request->file('cover_image');
         $file = $request->file('file');
//dd($image);
        if ($image !="") {
        $profilePicture = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('cover/images');
        $image->move($destinationPath, $profilePicture);
        $imagepath='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePicture;
        $input['cover_image']=$imagepath;
        }

        if ($file !="") {
        $profilePictures = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$file->getClientOriginalExtension();
        $destinationPaths = public_path('cover/images');
        $file->move($destinationPaths, $profilePictures);
        $imagepaths='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePictures;
        $input['image_url']=$imagepaths;
        }
        // dd($input);
       DB::table('wingg_app_post')->where('id', $id)->update($input);

        $wingg_app_postteam=DB::table('wingg_app_postteam')->where('post_id', $id)->first();

        if ($request->input('team') !="") {
          $team['team_id'] = $request->input('team');
        DB::table('wingg_app_postteam')->where('id', $wingg_app_postteam->id)->update($team);
      }

        $wingg_app_postposition=DB::table('wingg_app_postposition')->where('post_id', $id)->first();
        if ($request->input('role') !="") {
          $position['position_id']=$request->input('role');
        DB::table('wingg_app_postposition')->where('id', $wingg_app_postposition->id)->update($position);
      }
        $request->session()->flash('post', 'Post updated Sussessfully');
        return redirect('/dashboard');
      }

      $post=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
      ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
      ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
      ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
      ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
      ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
      ->where('wingg_app_postteam.post_id','=',$id)->first();
      //dd($post);
      return view('admin.edit_post_image', compact('post'));
    }


    // Edit External Link Post
    public function editPostLink(Request $request, $id)
    {
      if($request->isMethod('post')){
        $this->validate($request,[
          'link' => 'required|max:130',
        ]);
        //dd($request->all());
        $company_id=$request->session()->get('chat_admin')->company_id;
        $input['title']=$request->input('post_title');
        $input['media_url']=$request->input('link');
        $input['company_id']=$company_id;
        $input['dislikes']=0;
        $input['likes']=0;
        $input['created_at']=  date('Y-m-d H:i:s');
        $input['updated_at']=  date('Y-m-d H:i:s');
         $image = $request->file('cover_image');
         $file = $request->file('file');
//dd($image);
        if ($image !="") {
        $profilePicture = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('cover/images');
        $image->move($destinationPath, $profilePicture);
        $imagepath='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePicture;
        $input['cover_image']=$imagepath;
        }

        if ($file !="") {
        $profilePictures = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$file->getClientOriginalExtension();
        $destinationPaths = public_path('cover/images');
        $file->move($destinationPaths, $profilePictures);
        $imagepaths='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePictures;
        $input['image_url']=$imagepaths;
        }

       DB::table('wingg_app_post')->where('id', $id)->update($input);

        $wingg_app_postteam=DB::table('wingg_app_postteam')->where('post_id', $id)->first();


        $team['team_id'] = $request->input('team');
        DB::table('wingg_app_postteam')->where('id', $wingg_app_postteam->id)->update($team);

        $wingg_app_postposition=DB::table('wingg_app_postposition')->where('post_id', $id)->first();

        $position['position_id']=$request->input('role');
        DB::table('wingg_app_postposition')->where('id', $wingg_app_postposition->id)->update($position);
        $request->session()->flash('post', 'Post updated Sussessfully');
        return redirect('/dashboard');
      }

      $post=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
      ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
      ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
      ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
      ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
      ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
      ->where('wingg_app_postteam.post_id','=',$id)->first();
      //dd($post);
      return view('admin.edit_post_link', compact('post'));
    }

public function imagestore(Request $request)
    {
        if($request->isMethod('post')){
         //  dd($request->all());
        $company_id=$request->session()->get('chat_admin')->company_id;
            $input['title']=$request->input('post_title');
            $input['content']=$request->input('post_description');
            $input['company_id']=$company_id;
            $input['dislikes']=0;
            $input['likes']=0;
            $input['created_at']=  date('Y-m-d H:i:s');
            $input['updated_at']=  date('Y-m-d H:i:s');
             $image = $request->file('cover_image');
             $file = $request->file('file');
//dd($image);
            if ($image !="") {
            $profilePicture = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('cover/images');
            $image->move($destinationPath, $profilePicture);
            $imagepath='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePicture;
            $input['cover_image']=$imagepath;
            }

            if ($file !="") {
            $profilePictures = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$file->getClientOriginalExtension();
            $destinationPaths = public_path('cover/images');
            $file->move($destinationPaths, $profilePictures);
            $imagepaths='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePictures;
            $input['image_url']=$imagepaths;
            }

           $post_id=DB::table('wingg_app_post')->insertGetId( $input);

           $team['team_id']=$request->input('team');
           $team['post_id']=$post_id;
           $wingg_app_postteam=DB::table('wingg_app_postteam')->insertGetId($team);

           $position['position_id']=$request->input('role');
           $position['post_id']=$post_id;
           $wingg_app_postposition=DB::table('wingg_app_postposition')->insertGetId($position);
		   if($wingg_app_postposition){
			   $request->session()->flash('post', 'Post Create Sussessfully');
            //return redirect('/dashboard');
		   }
        }
       return view('admin.add-post');
    }


  public function mediastore(Request $request)
    {
      // dd($request->all());
        if($request->isMethod('post')){
          $this->validate($request,[
            'link' => 'required|max:130',
          ]);
           //dd($request->input());
        $company_id=$request->session()->get('chat_admin')->company_id;
            $input['title']=$request->input('post_title');
            $input['media_url']=$request->input('link');
            $input['company_id']=$company_id;
            $input['dislikes']=0;
            $input['likes']=0;
            $input['created_at']=  date('Y-m-d H:i:s');
            $input['updated_at']=  date('Y-m-d H:i:s');
             $image = $request->file('cover_image');
//dd($image);
            if ($image !="") {
            $profilePicture = 'cover_image-'.time().'-'.rand(000000,999999).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('cover/images');
            $image->move($destinationPath, $profilePicture);
            $imagepath='http://phplaravel-355796-1161525.cloudwaysapps.com/cover/images/'.$profilePicture;
            $input['cover_image']=$imagepath;
            }

           $post_id=DB::table('wingg_app_post')->insertGetId( $input);

           $team['team_id']=$request->input('team');
           $team['post_id']=$post_id;
           $wingg_app_postteam=DB::table('wingg_app_postteam')->insertGetId($team);

           $position['position_id']=$request->input('role');
           $position['post_id']=$post_id;
           $wingg_app_postposition=DB::table('wingg_app_postposition')->insertGetId($position);
            $request->session()->flash('post', 'Post Create Sussessfully');
            return redirect('/dashboard');
        }
       return view('admin.add-post');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function deletepost(Request $request,$id)
    {
        DB::table('wingg_app_postteam')->where('post_id',$id)->delete();
        DB::table('wingg_app_postposition')->where('post_id',$id)->delete();
        DB::table('wingg_app_post')->where('id',$id)->delete();
        $request->session()->flash('delnum', 'Post delete Successfully');
        return redirect('/dashboard');
    }



 public function teamsearch(Request $request)
    {
      // dd($request->all());
      $team = $request->input('team');
      $role = $request->input('role');
      $date = $request->input('date');
      $keyword = $request->input('keyword');

      $start_date='';
      $end_date='';
      if ($date !=null) {
        $data = explode(' / ',$date);
        $start_date =$data[0];
        $end_date =$data[1];
      }
      $user_id=$request->session()->get('chat_admin')->id;
        $posts2=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->get();
       $totalcount=$posts2->count();

        $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_postteam.team_id','=',$team);
        if ($role !=null) {
          $posts->where('wingg_app_postposition.position_id','=',$role);
        }
        if ($keyword !=null) {
          $posts->where('wingg_app_post.title', 'ilike', '%' . $keyword . '%');
        }
        if ($start_date !='' && $end_date !='') {
          if ($start_date == $end_date) {
            $posts->where('wingg_app_post.created_at','like','%'.$start_date.'%');
          }else {
            $posts->whereBetween('wingg_app_post.created_at',[$start_date, $end_date]);
          }
        }
        $posts=$posts->orderby('wingg_app_post.created_at','desc')->paginate(20);
        $total = count($posts->items());
        //dd($total);
        $output='';
        $x=[];
        $output .= '<table class="table">';
        $output .= ' <thead>';
        $output .= '<th colspan="2"></th>';
        $output .= '<th colspan="2">Title</th>';
        $output .= '<th colspan="">Created at</th>';
        $output .= '<th colspan="3">Team</th>';
        $output .= '<th colspan="3">Roles</th>';
        $output .= '<th colspan="3">Targeted Audience</th>';
        $output .= '<th colspan="3">Likes</th>';
        $output .= '<th colspan="3">Dislike</th>';
        $output .= '<th colspan="3">blank_field</th>';
        $output .= '<th colspan="3">blank_field</th>';

        $output .= '</thead>';
        $output .= '<tbody >';
        if(!$posts->isEmpty())
        {
            foreach($posts as $post)
            {
              $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              if($post->cover_image){
                  $cover_image=$post->cover_image;
              }else{
                $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              }
            $text_url = url('dashboard/edit-post-text/'.$post->id);
            $image_url = url('dashboard/edit-post-image/'.$post->id);
            $link_url = url('dashboard/edit-post-link/'.$post->id);
            $delete_url = url('dashboard/deletepost/'.$post->id);
            // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

            $output .= '<tr>';
              $output .= '<td class="action-btn" style="width: 9%;">';
                if($post->content){
                $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }elseif($post->image_url){
                $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }else{
                $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }
                $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
                $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
              $output .= '</td>';
              $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
                $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
              $output .= '</td>';
              $output .= '<td colspan="2"> '.$post->created_at.'</td>';
              $output .= '<td colspan="3"> '.$post->t_name.'</td>';
              $output .= '<td colspan="3"> '.$post->p_name.'</td>';
              $output .= '<td colspan="3"> 2812</td>';
              $output .= '<td colspan="3"> '.$post->likes.'</td>';
              $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
              $output .= '<td colspan="3"> -</td>';
              $output .= '<td colspan="3"> -</td>';
            $output .= '</tr>';
            }
            $output.='</tbody>';
            $output.='  </table>';
            $output.=$posts->render();
            // dd($output);

        }
        $x = array(
          'output' => $output,
          'total' => $total,
          'totalcount' => $totalcount,

      );
        echo json_encode($x);
        //dd($posts);
         // return view('admin.ajaxnews',compact('posts'));
    }
 public function search_ajax_main(Request $request)
    {
      // dd($request->all());
      $user_id=$request->session()->get('chat_admin')->id;
        $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->paginate(15);
        $total = count($posts->items());
        //dd($total);
        $totalcount = $posts->total();
        $output='';
        $output .= '<table class="table">';
        $output .= ' <thead>';
        $output .= '<th colspan="2"></th>';
        $output .= '<th colspan="2">Title</th>';
        $output .= '<th colspan="">Created at</th>';
        $output .= '<th colspan="3">Team</th>';
        $output .= '<th colspan="3">Roles</th>';
        $output .= '<th colspan="3">Targeted Audience</th>';
        $output .= '<th colspan="3">Likes</th>';
        $output .= '<th colspan="3">Dislike</th>';
        $output .= '<th colspan="3">blank_field</th>';
        $output .= '<th colspan="3">blank_field</th>';

        $output .= '</thead>';
        $output .= '<tbody >';

        if(!$posts->isEmpty())
        {
            foreach($posts as $post)
            {
              $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              if($post->cover_image){
                  $cover_image=$post->cover_image;
              }else{
                $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              }
            $text_url = url('dashboard/edit-post-text/'.$post->id);
            $image_url = url('dashboard/edit-post-image/'.$post->id);
            $link_url = url('dashboard/edit-post-link/'.$post->id);
            $delete_url = url('dashboard/deletepost/'.$post->id);
            // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

            $output .= '<tr>';
              $output .= '<td class="action-btn" style="width: 9%;">';
                if($post->content){
                $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }elseif($post->image_url){
                $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }else{
                $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }
                $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
                $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
              $output .= '</td>';
              $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
                $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
              $output .= '</td>';
              $output .= '<td colspan="2"> '.$post->created_at.'</td>';
              $output .= '<td colspan="3"> '.$post->t_name.'</td>';
              $output .= '<td colspan="3"> '.$post->p_name.'</td>';
              $output .= '<td colspan="3"> 2812</td>';
              $output .= '<td colspan="3"> '.$post->likes.'</td>';
              $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
              $output .= '<td colspan="3"> -</td>';
              $output .= '<td colspan="3"> -</td>';
            $output .= '</tr>';
            }
            $output.='</tbody>';
            $output.='  </table>';
            $output.=$posts->render();
        }
        $x = array(
          'output' => $output,
          'total' => $total,
          'totalcount' => $totalcount,

        );
        echo json_encode($x);
         // return view('admin.ajaxnews',compact('posts','total'));
    }


    public function positionsearch(Request $request)
    {
      // dd($request->all());
      $role = $request->input('role');
      $team = $request->input('team');
      $date = $request->input('date');
      $keyword = $request->input('keyword');
      $start_date='';
      $end_date='';
      if ($date !=null) {
        $data = explode(' / ',$date);
        $start_date =$data[0];
        $end_date =$data[1];
      }
      $user_id=$request->session()->get('chat_admin')->id;
        $posts2=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->get();
       $totalcount=$posts2->count();
        $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_postposition.position_id','=',$role);
        if ($team !=null) {
          $posts->where('wingg_app_postteam.team_id','=',$team);
      }
        if ($keyword !=null) {
          $posts->where('wingg_app_post.title', 'ilike', '%' . $keyword . '%');
      }
      if ($start_date !='' && $end_date !='') {
        if ($start_date == $end_date) {
          $posts->where('wingg_app_post.created_at','like','%'.$start_date.'%');
        }else {
          $posts->whereBetween('wingg_app_post.created_at',[$start_date, $end_date]);
        }
      }
        $posts=$posts->orderby('wingg_app_post.created_at','desc')->paginate(20);
        $total = count($posts->items());
        //dd($total);

        $output='';
        $output .= '<table class="table">';
        $output .= ' <thead>';
        $output .= '<th colspan="2"></th>';
        $output .= '<th colspan="2">Title</th>';
        $output .= '<th colspan="">Created at</th>';
        $output .= '<th colspan="3">Team</th>';
        $output .= '<th colspan="3">Roles</th>';
        $output .= '<th colspan="3">Targeted Audience</th>';
        $output .= '<th colspan="3">Likes</th>';
        $output .= '<th colspan="3">Dislike</th>';
        $output .= '<th colspan="3">blank_field</th>';
        $output .= '<th colspan="3">blank_field</th>';

        $output .= '</thead>';
        $output .= '<tbody >';

        if(!$posts->isEmpty())
        {
            foreach($posts as $post)
            {
              $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              if($post->cover_image){
                  $cover_image=$post->cover_image;
              }else{
                $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              }
            $text_url = url('dashboard/edit-post-text/'.$post->id);
            $image_url = url('dashboard/edit-post-image/'.$post->id);
            $link_url = url('dashboard/edit-post-link/'.$post->id);
            $delete_url = url('dashboard/deletepost/'.$post->id);
            // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

            $output .= '<tr>';
              $output .= '<td class="action-btn" style="width: 9%;">';
                if($post->content){
                $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }elseif($post->image_url){
                $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }else{
                $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }
                $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
                $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
              $output .= '</td>';
              $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
                $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
              $output .= '</td>';
              $output .= '<td colspan="2"> '.$post->created_at.'</td>';
              $output .= '<td colspan="3"> '.$post->t_name.'</td>';
              $output .= '<td colspan="3"> '.$post->p_name.'</td>';
              $output .= '<td colspan="3"> 2812</td>';
              $output .= '<td colspan="3"> '.$post->likes.'</td>';
              $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
              $output .= '<td colspan="3"> -</td>';
              $output .= '<td colspan="3"> -</td>';
            $output .= '</tr>';
            }
            $output.='</tbody>';
            $output.='  </table>';
            $output.=$posts->render();
        }
        $x = array(
          'output' => $output,
          'total' => $total,
          'totalcount' => $totalcount,

        );
        echo json_encode($x);
        //dd($posts);
         // return view('admin.ajaxnews',compact('posts'));
    }

    public function datesearch(Request $request)
    {
      // dd($request->all());
      $date = $request->input('date');
      $role = $request->input('role');
      $team = $request->input('team');
      $keyword = $request->input('keyword');
      $start_date='';
      $end_date='';
      if ($date !=null) {
        $data = explode(' / ',$date);
        $start_date =$data[0];
        $end_date =$data[1];
      }
      $user_id=$request->session()->get('chat_admin')->id;
        $posts2=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->get();
       $totalcount=$posts2->count();
        $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id');
        if ($start_date == $end_date) {
          $posts->where('wingg_app_post.created_at','like','%'.$start_date.'%');
        }else {
          $posts->whereBetween('wingg_app_post.created_at',[$start_date, $end_date]);
        }
        if ($keyword !=null) {
          $posts->where('wingg_app_post.title', 'ilike', '%' . $keyword . '%');
        }
        if ($role !=null) {
          $posts->where('wingg_app_postposition.position_id','=',$role);
        }
        if ($team !=null) {
          $posts->where('wingg_app_postteam.team_id','=',$team);
        }

        $posts=$posts->orderby('wingg_app_post.created_at','desc')->paginate(20);
        $total = count($posts->items());
        //dd($total);

        $output='';
        $output .= '<table class="table">';
        $output .= ' <thead>';
        $output .= '<th colspan="2"></th>';
        $output .= '<th colspan="2">Title</th>';
        $output .= '<th colspan="">Created at</th>';
        $output .= '<th colspan="3">Team</th>';
        $output .= '<th colspan="3">Roles</th>';
        $output .= '<th colspan="3">Targeted Audience</th>';
        $output .= '<th colspan="3">Likes</th>';
        $output .= '<th colspan="3">Dislike</th>';
        $output .= '<th colspan="3">blank_field</th>';
        $output .= '<th colspan="3">blank_field</th>';

        $output .= '</thead>';
        $output .= '<tbody >';

        if(!$posts->isEmpty())
        {
            foreach($posts as $post)
            {
              $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              if($post->cover_image){
                  $cover_image=$post->cover_image;
              }else{
                $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              }
            $text_url = url('dashboard/edit-post-text/'.$post->id);
            $image_url = url('dashboard/edit-post-image/'.$post->id);
            $link_url = url('dashboard/edit-post-link/'.$post->id);
            $delete_url = url('dashboard/deletepost/'.$post->id);
            // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

            $output .= '<tr>';
              $output .= '<td class="action-btn" style="width: 9%;">';
                if($post->content){
                $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }elseif($post->image_url){
                $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }else{
                $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }
                $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
                $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
              $output .= '</td>';
              $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
                $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
              $output .= '</td>';
              $output .= '<td colspan="2"> '.$post->created_at.'</td>';
              $output .= '<td colspan="3"> '.$post->t_name.'</td>';
              $output .= '<td colspan="3"> '.$post->p_name.'</td>';
              $output .= '<td colspan="3"> 2812</td>';
              $output .= '<td colspan="3"> '.$post->likes.'</td>';
              $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
              $output .= '<td colspan="3"> -</td>';
              $output .= '<td colspan="3"> -</td>';
            $output .= '</tr>';
            }
            $output.='</tbody>';
            $output.='  </table>';
            $output.=$posts->render();
        }
        $x = array(
          'output' => $output,
          'total' => $total,
          'totalcount' => $totalcount,

        );
        echo json_encode($x);
         // return view('admin.ajaxnews',compact('posts'));
    }

 public function search(Request $request)
    {
        // dd($request->all());
        $keyword = $request->searchkeyword;
        $team = $request->team;
        $role = $request->role;
        $date = $request->date;
        $start_date='';
        $end_date='';
        if ($date !=null) {
          $data = explode(' / ',$date);
          $start_date =$data[0];
          $end_date =$data[1];
        }

        $user_id=$request->session()->get('chat_admin')->id;
          $posts2=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
          ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
          ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
          ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
          ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
          ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
          ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->get();
         $totalcount=$posts2->count();
        $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_post.title', 'ilike', '%' . $keyword . '%');
        if ($role !=null) {
          $posts->where('wingg_app_postposition.position_id','=',$role);
        }
        if ($team !=null) {
          $posts->where('wingg_app_postteam.team_id','=',$team);
      }
      if ($start_date !='' && $end_date !='') {
        if ($start_date == $end_date) {
          $posts->where('wingg_app_post.created_at','like','%'.$start_date.'%');
        }else {
          $posts->whereBetween('wingg_app_post.created_at',[$start_date, $end_date]);
        }
      }
        $posts=$posts->orderby('wingg_app_post.created_at','desc')->paginate(20);
        $total = count($posts->items());
        //dd($total);

        $output='';
        $output .= '<table class="table">';
        $output .= ' <thead>';
        $output .= '<th colspan="2"></th>';
        $output .= '<th colspan="2">Title</th>';
        $output .= '<th colspan="">Created at</th>';
        $output .= '<th colspan="3">Team</th>';
        $output .= '<th colspan="3">Roles</th>';
        $output .= '<th colspan="3">Targeted Audience</th>';
        $output .= '<th colspan="3">Likes</th>';
        $output .= '<th colspan="3">Dislike</th>';
        $output .= '<th colspan="3">blank_field</th>';
        $output .= '<th colspan="3">blank_field</th>';

        $output .= '</thead>';
        $output .= '<tbody >';

        if(!$posts->isEmpty())
        {
            foreach($posts as $post)
            {
              $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              if($post->cover_image){
                  $cover_image=$post->cover_image;
              }else{
                $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
              }
            $text_url = url('dashboard/edit-post-text/'.$post->id);
            $image_url = url('dashboard/edit-post-image/'.$post->id);
            $link_url = url('dashboard/edit-post-link/'.$post->id);
            $delete_url = url('dashboard/deletepost/'.$post->id);
            // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

            $output .= '<tr>';
              $output .= '<td class="action-btn" style="width: 9%;">';
                if($post->content){
                $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }elseif($post->image_url){
                $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }else{
                $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                }
                $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
                $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
              $output .= '</td>';
              $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
                $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
              $output .= '</td>';
              $output .= '<td colspan="2"> '.$post->created_at.'</td>';
              $output .= '<td colspan="3"> '.$post->t_name.'</td>';
              $output .= '<td colspan="3"> '.$post->p_name.'</td>';
              $output .= '<td colspan="3"> 2812</td>';
              $output .= '<td colspan="3"> '.$post->likes.'</td>';
              $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
              $output .= '<td colspan="3"> -</td>';
              $output .= '<td colspan="3"> -</td>';
            $output .= '</tr>';
            }
            $output.='</tbody>';
            $output.='  </table>';
            $output.=$posts->render();
        }
        $x = array(
          'output' => $output,
          'total' => $total,
          'totalcount' => $totalcount,

        );
        echo json_encode($x);
         // return view('admin.ajaxnews',compact('posts'));
    }

    public function allcsv(Request $request)
    {
     $user_id=$request->session()->get('chat_admin')->id;
        $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
        ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
        ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
        ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
        ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
        ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
        ->where('wingg_app_user.id','=',$user_id)->get();
    $filename = "news.csv";
    $handle = fopen($filename, 'w+');
    fputcsv($handle, array('Title', 'Team', 'Roles','Targeted Audience', 'Likes', 'Dislike'));

    foreach($posts as $row) {
        fputcsv($handle, array($row->title, $row->t_name, $row->p_name,'200',$row->likes, $row->dislikes));
    }

    fclose($handle);

    $headers = array(
         'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Content-Disposition' => 'attachment; filename=abc.csv',
        'Expires' => '0',
        'Pragma' => 'public',
    );

    return Response::download($filename, 'news.csv', $headers);
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function teamPost($id)
     {

          return view('admin.team');
     }
     public function teamPostajax(Request $request,$id)
      {
        $user_id=$request->session()->get('chat_admin')->id;
          $posts2=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
          ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
          ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
          ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
          ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
          ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
          ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->get();

          $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
          ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
          ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
          ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
          ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
          ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
          ->where('wingg_app_postteam.team_id','=',$id)->paginate(20);
          //dd($posts);
          $total = count($posts->items());
          $totalcount=$posts2->count();
          //dd($total);

          $output='';
          $output .= '<table class="table">';
          $output .= ' <thead>';
          $output .= '<th colspan="2"></th>';
          $output .= '<th colspan="2">Title</th>';
          $output .= '<th colspan="">Created at</th>';
          $output .= '<th colspan="3">Team</th>';
          $output .= '<th colspan="3">Roles</th>';
          $output .= '<th colspan="3">Targeted Audience</th>';
          $output .= '<th colspan="3">Likes</th>';
          $output .= '<th colspan="3">Dislike</th>';
          $output .= '<th colspan="3">blank_field</th>';
          $output .= '<th colspan="3">blank_field</th>';

          $output .= '</thead>';
          $output .= '<tbody >';

          if(!$posts->isEmpty())
          {
              foreach($posts as $post)
              {
                $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
                if($post->cover_image){
                    $cover_image=$post->cover_image;
                }else{
                  $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
                }
              $text_url = url('dashboard/edit-post-text/'.$post->id);
              $image_url = url('dashboard/edit-post-image/'.$post->id);
              $link_url = url('dashboard/edit-post-link/'.$post->id);
              $delete_url = url('dashboard/deletepost/'.$post->id);
              // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

              $output .= '<tr>';
                $output .= '<td class="action-btn" style="width: 9%;">';
                  if($post->content){
                  $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                  }elseif($post->image_url){
                  $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                  }else{
                  $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                  }
                  $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
                  $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
                $output .= '</td>';
                $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
                  $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
                $output .= '</td>';
                $output .= '<td colspan="2"> '.$post->created_at.'</td>';
                $output .= '<td colspan="3"> '.$post->t_name.'</td>';
                $output .= '<td colspan="3"> '.$post->p_name.'</td>';
                $output .= '<td colspan="3"> 2812</td>';
                $output .= '<td colspan="3"> '.$post->likes.'</td>';
                $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
                $output .= '<td colspan="3"> -</td>';
                $output .= '<td colspan="3"> -</td>';
              $output .= '</tr>';
              }
              $output.='</tbody>';
              $output.='  </table>';
              $output.=$posts->render();
          }
          $x = array(
            'output' => $output,
            'total' => $total,
            'totalcount' => $totalcount,

          );
          echo json_encode($x);
      }

      public function postionPost($id)
      {

           return view('admin.role');
      }
     public function postionPostajax(Request $request,$id)
     {
       $user_id=$request->session()->get('chat_admin')->id;
         $posts2=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
         ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
         ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
         ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
         ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
         ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
         ->where('wingg_app_user.id','=',$user_id)->orderby('wingg_app_post.created_at','desc')->get();

         $posts=DB::table('wingg_app_post')->select('wingg_app_post.*','wingg_app_position.name AS p_name','wingg_app_team.name AS t_name')
         ->join('wingg_app_user','wingg_app_user.company_id','=','wingg_app_post.company_id')
         ->join('wingg_app_postteam','wingg_app_postteam.post_id','=','wingg_app_post.id')
         ->join('wingg_app_postposition','wingg_app_postposition.post_id','=','wingg_app_post.id')
         ->join('wingg_app_team','wingg_app_team.id','=','wingg_app_postteam.team_id')
         ->join('wingg_app_position','wingg_app_position.id','=','wingg_app_postposition.position_id')
         ->where('wingg_app_postposition.position_id','=',$id)->paginate(20);
         $total = count($posts->items());
         $totalcount=$posts2->count();
         //dd($total);

         $output='';
         $output .= '<table class="table">';
         $output .= ' <thead>';
         $output .= '<th colspan="2"></th>';
         $output .= '<th colspan="2">Title</th>';
         $output .= '<th colspan="">Created at</th>';
         $output .= '<th colspan="3">Team</th>';
         $output .= '<th colspan="3">Roles</th>';
         $output .= '<th colspan="3">Targeted Audience</th>';
         $output .= '<th colspan="3">Likes</th>';
         $output .= '<th colspan="3">Dislike</th>';
         $output .= '<th colspan="3">blank_field</th>';
         $output .= '<th colspan="3">blank_field</th>';

         $output .= '</thead>';
         $output .= '<tbody >';

         if(!$posts->isEmpty())
         {
             foreach($posts as $post)
             {
               $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
               if($post->cover_image){
                   $cover_image=$post->cover_image;
               }else{
                 $cover_image=url('frontend-assets/dashboard/img/faces/abc1.jpg');
               }
             $text_url = url('dashboard/edit-post-text/'.$post->id);
             $image_url = url('dashboard/edit-post-image/'.$post->id);
             $link_url = url('dashboard/edit-post-link/'.$post->id);
             $delete_url = url('dashboard/deletepost/'.$post->id);
             // $output .= '<div class="col-md-6 listing-grid img-append-grid" style="padding-left: 0;padding-right: 0;padding-bottom: 10px;margin-left: -4px;  width: 49.6%;">';

             $output .= '<tr>';
               $output .= '<td class="action-btn" style="width: 9%;">';
                 if($post->content){
                 $output .= '<a href="'.$text_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                 }elseif($post->image_url){
                 $output .= '<a href="'.$image_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                 }else{
                 $output .= '<a href="'.$link_url.'" style="color:gray;"><i class="material-icons">edit</i></a>';
                 }
                 $output .= '<a href="'.$delete_url.'" class="demo" style="color:gray;"><i class="material-icons">delete</i></a>';
                 $output .= '<a href="" style="color:gray"><i class="material-icons">visibility</i></a>';
               $output .= '</td>';
               $output .= '<td colspan="2"> <img src="'.$cover_image.'" height="70px" width="60px" class="pull-left">';
                 $output .= '<span class="pl-10" style="display: flex;">'.$post->title.'</span>';
               $output .= '</td>';
               $output .= '<td colspan="2"> '.$post->created_at.'</td>';
               $output .= '<td colspan="3"> '.$post->t_name.'</td>';
               $output .= '<td colspan="3"> '.$post->p_name.'</td>';
               $output .= '<td colspan="3"> 2812</td>';
               $output .= '<td colspan="3"> '.$post->likes.'</td>';
               $output .= '<td colspan="3"> '.$post->dislikes.'</td>';
               $output .= '<td colspan="3"> -</td>';
               $output .= '<td colspan="3"> -</td>';
             $output .= '</tr>';
             }
             $output.='</tbody>';
             $output.='  </table>';
             $output.=$posts->render();
         }
         $x = array(
           'output' => $output,
           'total' => $total,
           'totalcount' => $totalcount,

         );
         echo json_encode($x);
     }
}
