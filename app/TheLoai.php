<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    protected $table  = 'theloai';

    public function loaitin(){
    	// 1 the loai co nhieu loai tin dung hasMany vs khoa phu id_theloai
    	// va khoa chinh id
    	return $this->hasMany('App\LoaiTin','idTheLoai','id');
    }

    //muon biet trong the loai co bnh tin tuc
    public function tintuc()
    {
    	return $this->hasManyThrough('App\TinTuc','App\LoaiTin','idTheLoai','idLoaiTin','id');
    }
}
