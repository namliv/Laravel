<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\Slide;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
	function __construct()
	{
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view()->share('theloai',$theloai);
		view()->share('slide',$slide);

		if(Auth::check())
		{
			view()->share('nguoidung',Auth::user());
		}
	}
	function trangchu()
	{
        //truyen the loai sang trangchu
		return view('pages.trangchu');
	}
	function lienhe()
	{
		return view('pages.lienhe');
	}
	function loaitin($id)
	{
		$loaitin = LoaiTin::find($id);
		$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
		return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
	}
	function tintuc($id)
	{
		$tintuc = TinTuc::find($id);
		$tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
		$tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();

		return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
	}

	function getDangnhap()
	{
		return view('pages.dangnhap');
	}
	function postDangnhap(Request $request)
	{
		$this->validate($request,
			[
			'email' => 'required|email|',
			'password' => 'required|min:3|max:32',
			],
			[
			'email.required' => 'Bạn chưa nhập email',
			'email.email' => 'Bạn phải nhập đúng định dạng email',
			'password.required' => 'Bạn chưa nhập password',
			'password.min' => 'Password phải lớn hơn 3 kí tự và nhỏ hơn 32 kí tự',
			]);

		if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
		{
			return redirect('trangchu');
		}
		else{
			return redirect('dangnhap')->with('thongbao','Đăng Nhập Không Thành Công');
		}
	}

	function getDangxuat()
	{
		Auth::logout();
		return redirect('trangchu');
	}
}
