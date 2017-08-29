<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TinTuc;
use App\TheLoai;
use App\LoaiTin;
use App\Comment;
use App\Slide;
use App\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
	public function getDanhSach()
	{
		$user = User::all();
		return view('admin.user.danhsach',['user'=>$user]);
	}

	public function getThem()
	{
		return view('admin.user.them');
	}

	public function postThem(Request $request)
	{
		$this->validate($request,
			[
			'name' => 'required|min:3',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:3|max:32',
			'passwordAgain' => 'required|same:password'
			],
			[
			'name.required' => 'Bạn chưa nhập tên',
			'name.min' => 'Tên tối thiểu ít nhất 3 kí tự',
			'email.required' => 'Bạn chưa nhập email',
			'email.email' => 'Bạn phải nhập đúng định dạng email',
			'email.unique' => 'Email đã bị trùng',
			'password.required' => 'Bạn chưa nhập password',
			'password.min' => 'Password phải lớn hơn 3 kí tự và nhỏ hơn 32 kí tự',
			'passwordAgain.required' => 'Bạn chưa nhập lại Password',
			'passwordAgain.same' => 'Password chưa khớp'
			]);

		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->quyen = $request->quyen;
		$user->save();

		return redirect('admin/user/them')->with('thongbao','Thêm Thành Công');
	}

	public function getSua($id)
	{
		$user = User::find($id);

		return view('admin.user.sua',['user'=>$user]);
	}

	public function postSua(Request $request,$id)
	{
		$this->validate($request,
			[
			'name' => 'required|min:3',
			],
			[
			'name.required' => 'Bạn chưa nhập tên',
			'name.min' => 'Tên tối thiểu ít nhất 3 kí tự',
			]);
		$user = User::find($id);
		$user->name = $request->name;
		$user->quyen = $request->quyen;

		if($request->changePasssword == "on")
		{
			$this->validate($request,
				[
				'password' => 'required|min:3|max:32',
				'passwordAgain' => 'required|same:password'
				],
				[
				'password.required' => 'Bạn chưa nhập password',
				'password.min' => 'Password phải lớn hơn 3 kí tự và nhỏ hơn 32 kí tự',
				'passwordAgain.required' => 'Bạn chưa nhập lại Password',
				'passwordAgain.same' => 'Password chưa khớp'
				]);
			$user->password = bcrypt($request->password);
		}

		$user->save();
		return redirect('admin/user/sua/'.$id)->with('thongbao','Sửa Thành Công');
	}

	public function getXoa($id)
	{
		$user = User::find($id);
		$comment = Comment::where('idUser',$id);
		$comment->delete();
		$user->delete();

		return redirect('admin/user/danhsach')->with('thongbao','Xóa Thành Công');
	}

	// dang nhap
	public function getdangnhapAdmin()
	{
		return view('admin.login');
	}
	public function postdangnhapAdmin(Request $request)
	{
		$this->validate($request,
			[
			'email' => 'required',
			'password' => 'required|min:3|max:32'
			],
			[
			'email.required' => 'Bạn chưa nhập Email',
			'password.required' => 'Bạn chưa nhập Password',
			'password.min' => 'Password ko được nhỏ hơn 3 kí tự',
			'password.max' => 'Password ko được lớn hơn 32 kí tự' 
			]);
		if(Auth::attempt(['email' => $request->email,'password'=>$request->password]))
		{
			return redirect('admin/theloai/danhsach');
		}
		else
		{
			return redirect('admin/dangnhap')->with('thongbao','Đăng nhập thất bại');
		}
	}

	public function getdangxuatAdmin()
	{
		Auth::logout();
		return redirect('admin/dangnhap');
	}
}
