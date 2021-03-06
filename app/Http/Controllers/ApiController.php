<?php

namespace App\Http\Controllers;

use App\FeedbackQuestion;
use App\Jobs\UserRegisteredNotifyJob;
use App\Mail\ApproveUser;
use App\Mail\HelloUser;
use App\Mail\RejectUser;
use App\Mail\UserRegistered;
use App\PagesService;
use App\Post;
use App\Subscriber;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    function getSearch($text, $take = 20, $offset = 0){
    	$result = [
    		'items' => [],
	    ];

    	$items = Post::with(['postType.page'])
				->byText($text)
				->skip($offset)
				->take($take)
		        ->orderBy('created_at', 'desc')
				->get();

	    forEach($items as $item){
		    $result['items'][] = [
		    	'title' => $item->title,
			    'excerpt' => $item->excerpt,
			    'type' => $item->postType->name,
			    'url' => $item->url,
                'created' => $item->created,
			    'image' => url($item->image)
		    ];
	    }

	    return $result;
    }

    function getOPcacheReset(){
    	\opcache_reset();
    }

    function postSubscribe(Request $request){
        if ($email = $request->get('email',false)) {
            Subscriber::firstOrCreate([ 'email' => $email ]);
        }
    }

    function postFeedback(Request $request){

        $params = ['name', 'email', 'subject', 'text'];
        if (count( ($requestParams = $request->only($params)) ) == count($params)) {

            FeedbackQuestion::create($requestParams);
        }
    }

    function postStudentRegister(Request $request){
    	$validationRules = [
    		'firstname' => 'required|max:191',
		    'lastname' => 'required|max:191',
		    'b_day' => 'required',
		    'b_month' => 'required',
		    'b_year' => 'required',
		    'address' => 'required',
		    'phone_home' => 'required',
		    'phone_mobile' => 'required',
		    'email' => 'required|email',
		    'f1' => 'required',
		    'f2' => 'required',
		    'f3' => 'required',
		    'f4' => 'required',
		    'f5' => 'required',
		    'f6' => 'required',
		    'f7' => 'required',
		    'f8' => 'required',
		    'f9' => 'required'
	    ];

    	$validator = Validator::make( $request->only(array_keys($validationRules)) , $validationRules);

		if ($validator->fails()){

            session()->push('messages', 'Необходимо заполнить все поля анкеты!');
			return redirect()->back()->withErrors($validator->errors())->withInput($request->all());

		}

		$userEmail = $request->get('email', '');

        if ($kpro = Post::kpro()->whereHas('students', function($q) use ($userEmail){
                $q->where('email', $userEmail)->where('posts_users.status','=','enabled');
            })->first()){

            session()->push('messages', 'Пользователь с указанным e-mail адресом уже зарегистрирован в k-pro');
            return redirect()->back()->withInput($request->all());
        }

        if (!($kpro = Post::kpro()->where('status', \App\Post::POST_STATUS_ENABLED)->first())){

            session()->push('messages', 'Отсутствует программа k-pro, доступная для регистрации.');

            return redirect()->back()->withInput($request->all());
        }

		$user = User::where('email', $request->get('email', ''))->first();

		if (!isset($user)) $user = new User();

	    $user['email'] = $userEmail;
        $user['type'] = 'student';

	    $user['name'] = $request->get('firstname') . ' ' .
	                    $request->get('lastname') .
	                    ($request->get('patronymic', false) ? ' ' . $request->get('patronymic') : '');
	    $user['meta->firstname'] = $request->get('firstname');
	    $user['meta->lastname'] = $request->get('lastname');
	    $user['meta->patronymic'] = $request->get('patronymic');
	    $user['meta->birth_date'] = $request->get('b_day').'.'.$request->get('b_month').'.'.$request->get('b_year');
	    $user['meta->address'] = $request->get('address');
	    $user['meta->phone_home'] = $request->get('phone_home');
	    $user['meta->phone_mobile'] = $request->get('phone_mobile');
	    $user['meta->f1'] = $request->get('f1');
	    $user['meta->f2'] = $request->get('f2');
	    $user['meta->f3'] = $request->get('f3');
	    $user['meta->f4'] = $request->get('f4');
	    $user['meta->f5'] = $request->get('f5');
	    $user['meta->f6'] = $request->get('f6');
	    $user['meta->f7'] = $request->get('f7');
	    $user['meta->f8'] = $request->get('f8');
	    $user['meta->f9'] = $request->get('f9');
        $user['meta->f10'] = $request->get('f10');
	    $user['password'] = bcrypt('1234567890');
	    $user['status'] = 'disabled';

        foreach ($request->allFiles() as $file){

            $newfileName = $user['name'].'_'.$file->getClientOriginalName();

            $files[] = 'uploads/Анкеты студентов/' . $newfileName;

            Storage::disk('public')
                ->putFileAs('uploads/Анкеты студентов', $file, $newfileName);
        }

        if (isset($files)) {

            $user['meta->files'] = json_encode( array_map(function($f){ return '/storage/' . $f; }, $files) );
        }

        $user->save();

        $user['files'] = isset($files) ? $files : [];

        $kpro->students()->attach($user->id,  [ 'type' => 'student', 'status' => 'disabled' ]);

        session()->push('messages', 'Ваша заявка принята, ответ будет предоставлен на указанный e-mail.');

        UserRegisteredNotifyJob::dispatch( $user );

	    return redirect( url( PagesService::pageRoute('kpro')));
    }

    function postStudentLogin(Request $request){

    	if (Auth::attempt([
    		    'email' => $request->get('email', 'email'),
		        'password' => $request->get('password', 'password')
	        ])){

    		return redirect( url(PagesService::pageRoute('kpro')) );

	    } else {

            session()->push('messages', 'Логин/пароль введены неверно!');

		    return redirect( url(PagesService::pageRoute('kpro_login')));
	    }

	}

	function postStudentChangePassword(Request $request){

    	if (!empty($pass = $request->get('password', ''))){

    		Auth::user()->password = bcrypt($pass);
		    Auth::user()->save();

    		session()->push('messages', 'Пароль обновлен.');
	    } else {
		    session()->push('messages', 'Указан некорректный пароль.');
	    }

		return redirect( url(PagesService::pageRoute('kpro')) );
	}

	function postStudentLogout(){

		Auth::logout();

		return redirect( url(PagesService::pageRoute('kpro')) );
	}

	function getStudents(){
		if ($kpro = Post::kpro()->where('status', Post::POST_STATUS_ENABLED)
		                        ->with(['students' => function($q){
		                        	$q->wherePivot('status','=','disabled');
		                        }])
		                        ->first()){
		}

		return ['program' => $kpro];
	}

	function postStudentsApprove(Request $request){

		if ($student = $request->get('student', false)){

			if ($user = User::where('email','=',$student['email'])->first()){

                if ($kpro = Post::kpro()->where('status', Post::POST_STATUS_ENABLED)->first()){

                    DB::table('posts_users')
                        ->where('user_id', $user->id)
                        ->where('post_id', $kpro->id)
                        ->update([ 'status' => 'enabled']);

                }

				$newPassword = explode('@', $user->email)[0].Carbon::now()->format('dMy');

				$user->status = 'enabled';
				$user->password = bcrypt($newPassword);
				$user->save();

				$user->newPassword = $newPassword;

				Mail::to($user->email)->send( new ApproveUser($user));
			}
		}

		return [ 'status' => 'success'];
	}

	function postStudentsReject(Request $request){

		if ($student = $request->get('student', false)){
			if ($user = User::where('email','=',$student['email'])->first()){

				Mail::to($user->email)->send( new RejectUser($user));
				$user->delete();
			}
		}

		return [ 'status' => 'success'];
	}

}
