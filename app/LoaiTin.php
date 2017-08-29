<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiTin extends Model
{
    protected $table  = 'loaitin';

    public function theloai()
    {
    	return $this->belongsTo('App\TheLoai','idTheLoai','id');
    }

    //trong loai tin co bnh tin
    public function tintuc()
    {
    	return $this->hasMany('App\TinTuc','idLoaiTin','id');
    }
}
