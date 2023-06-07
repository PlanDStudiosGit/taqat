<x-admin-layout>
    <x-slot name="pageName">{{ $pageName }}</x-slot>
        <x-slot name="breadCrumbs">
            <x-admin.breadcrumbs :pageName="$pageName" :breadCrumbs="$breadCrumbs"/>
        </x-slot>
    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ route('admin.account.update', ['id' => $user->id]) }}">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}" required>
              </div>
              <div class="form-group col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}" required>
              </div>
              <div class="form-group col-md-6">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="********">
                <small>Leave empty to keep current password</small>
              </div>
              <div class="form-group col-md-6">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="*********">
              </div>
              <div class="col-md-12">
                <div class="cus-btn text-right">
                    <a href="{{ route('admin.dashboard') }}" class="cancle-btn">Back</a>
                    <button type="submit" class="send-btn">Submit</button>
                </div>
              </div>
            </div>

          </form>
      </div>
    <x-slot name="pluginCss"></x-slot>
</x-admin-layout>
