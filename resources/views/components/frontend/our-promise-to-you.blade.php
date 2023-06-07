</x-slot>
    <div class="dealership-form">
        <form class="myform" method="POST" action="{{ !empty($brand)? route('admin.brand.update', ['id' => $brand->id]) : route('admin.brand.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Title</label>
                    <input maxlength="255" type="text" name="name" class="form-control" required placeholder="Name" value="" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Name</label>
                    <input maxlength="255" type="text" name="slug" class="form-control" required placeholder="Slug" value="" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="cus-btn text-right">
                        <a href="" class="cancle-btn">Back</a>
                        <button type="submit" class="send-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>