@extends('admin.layout.index')

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin Tức
                    <small>{{ $tintuc->TieuDe }}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
             @if(count($errors)>0)
             <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                {{ $err }}<br>
                @endforeach
            </div>
            @endif
            @if(session('thongbao'))
            <div class="alert alert-success">
                {{ session('thongbao') }}
            </div>
            @endif
            <form action="admin/tintuc/sua/{{ $tintuc->id }}" method="POST" enctype="multipart/form-data">
             <input type="hidden" name="_token" value="{{ csrf_token() }}" />
             <div class="form-group">
                <label>Thể Loại</label>
                <select class="form-control" id="TheLoai" name="TheLoai">
                    @foreach($theloai as $tl)
                    <option 
                    @if($tintuc->loaitin->theloai->id == $tl->id)
                    {{ "selected" }}
                    @endif
                    value="{{ $tl->id }}">{{ $tl->Ten }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Loại Tin</label>
                <select class="form-control" name="LoaiTin" id="LoaiTin">
                    @foreach($loaitin as $lt)
                    <option 
                    @if($tintuc->loaitin->id == $lt->id)
                    {{ "selected" }}
                    @endif
                    value="{{ $lt->id }}">{{ $lt->Ten }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tiêu Đề</label>
                <input type="text" name="TieuDe" class="form-control" value="{{ $tintuc->TieuDe }}" placeholder="Nhập Tiêu Đề">
            </div>

            <div class="form-group">
                <label>Tóm Tắt</label>
                <textarea name="TomTat" id="demo" class="form-control ckeditor" rows="3">
                    {{ $tintuc->TomTat }}
                </textarea>
            </div>

            <div class="form-group">
                <label>Nội Dung</label>
                <textarea name="NoiDung" id="demo" class="form-control ckeditor" rows="3">
                    {{ $tintuc->NoiDung }}
                </textarea>
            </div>
            <div class="form-group">
                <label>Hình Ảnh</label>
                <p><img width="400px" src="upload/tintuc/{{ $tintuc->Hinh }}" alt=""/></p>
                <input type="file" name="Hinh" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label>Nổi Bật</label>
                <label class="radio-inline">
                    <input name="NoiBat" value="0" 
                    @if($tintuc->NoiBat == 0)
                    {{ "checked" }}
                    @endif
                    type="radio"/>Không
                </label>
                <label class="radio-inline">
                    <input name="NoiBat" value="1"
                    @if($tintuc->NoiBat == 1)
                    {{ "checked" }}
                    @endif
                    type="radio"/>Có
                </label>
            </div>
            <button type="submit" class="btn btn-default">Sửa</button>
            <button type="reset" class="btn btn-default">Làm Mới</button>
        </form>
    </div>
</div>
<!-- /.row -->
<!-- Tao danh sach cm -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Bình Luận
            <small>Danh Sách</small>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
    @if(session('thongbao'))
    <div class="alert alert-success">
        {{ session('thongbao') }}
    </div>
    @endif
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Người dùng</th>
                <th>Nội dung</th>
                <th>Ngày Đăng</th>
                <th>Xóa</th>
                <!-- <th>Sửa</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($tintuc->comment as $cm)
            <tr class="odd gradeX" align="center">
                <td>{{ $cm->id }}</td>
                <td>{{ $cm->user->name }}</td>
                <td>{{ $cm->NoiDung }}</td>
                <td>{{ $cm->created_at }}</td>
                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/comment/xoa/{{ $cm->id }}/{{ $tintuc->id }}"> Xóa</a></td>
                <!-- <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/comment/sua/{{ $cm->id }}">Sửa</a></td> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /end - .row -->

</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


@endsection
@section('script')
<script>
    $(document).ready(function(){
        $("#TheLoai").change(function(){
            var idTheLoai = $(this).val();
            $.get('admin/ajax/loaitin/'+idTheLoai,function(data){
                $("#LoaiTin").html(data);
            });
        });
    });
</script>
@endsection