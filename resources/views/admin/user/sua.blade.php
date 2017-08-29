@extends('admin.layout.index')

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>{{ $user->name }}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
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
                <form action="admin/user/sua/{{ $user->id }}" method="POST">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                 <div class="form-group">
                    <label>Họ Tên</label>
                    <input class="form-control" name="name" value="{{ $user->name }}" placeholder="Nhập Tên Người Dùng" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" readonly="" class="form-control" name="email" value="{{ $user->email }}" placeholder="nhập địa chỉ email" />
                </div>
                <div class="form-group">
                    <input type="checkbox" id="changePassword" name="changPassword" value="">
                    <label>Đổi Mật Khẩu</label>
                    <input type="password" class="form-control password" name="password" placeholder="Nhập mật khẩu" disabled="" />
                </div>
                <div class="form-group">
                    <label>Nhập Lại Mật Khẩu</label>
                    <input type="password" class="form-control password" name="passwordAgain" placeholder="Nhập lại mật khẩu" disabled="" />
                </div>
                <div class="form-group">
                    <label>Quyền Người Dùng</label>
                    <label class="radio-inline">
                        <input name="quyen" value="0" 
                        @if($user->quyen == 0)
                        {{ "checked" }}
                        @endif
                        type="radio">Thường
                    </label>
                    <label class="radio-inline">
                        <input name="quyen" value="1"
                        @if($user->quyen == 1)
                        {{ "checked" }}
                        @endif
                        type="radio">Admin
                    </label>
                </div>
                <button type="submit" class="btn btn-default">Sửa</button>
                <button type="reset" class="btn btn-default">Reset</button>
            </form>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#changePassword").change(function(){
            if($(this).is(":checked"))
            {
                $(".password").removeAttr('disabled');
            }
            else
            {
                $(".password").attr('disabled','');
            }
        });
    });
</script>
@endsection