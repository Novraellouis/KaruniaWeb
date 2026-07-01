<x-app-layout title="Food">
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <!--Hotel detail start-->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Edit Restaurant</h5>
                                </div>
                                <div class="card-body">
                                    <form class="theme-form mega-form" id="form_input" method="PUT"
                                        action="{{ route('admin.food.update', $food->id) }}"
                                        enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label-title">Nama Produk</label>
                                            <input class="form-control" type="text" placeholder="Hotal Name"
                                                name="title" value="{{ $food->title }}" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label-title">Categori</label>
                                            <select name="category" class="form-select">
                                                <option disabled selected>Pilih Kategori</option>
                                                <option value="Makanan"
                                                    {{ $food->category == 'Makanan' ? 'selected' : '' }}>Makanan
                                                </option>
                                                <option value="Minuman"
                                                    {{ $food->category == 'Minuman' ? 'selected' : '' }}>Minuman
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label-title">Harga</label>
                                            <input class="form-control" type="text" placeholder="Price"
                                                name="price" value="{{ $food->price }}" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label-title">Stock</label>
                                            <input class="form-control" type="text" placeholder="Stock"
                                                name="stock" value="{{ $food->stock }}" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label-title mt-4">Gambar</label>
                                                <br>
                                                @if ($food->cover)
                                                    <img src="{{ asset('images/food/' . $food->cover) }}"
                                                        alt="Cover"
                                                        width="200"
                                                        class="img-thumbnail mb-3">
                                                @endif
                                            <input class="form-control" type="file" name="cover" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label-title">Description</label>
                                            <textarea class="form-control" name="description" placeholder="Description">
                                                {{ $food->description }}
                                            </textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary me-3" type="submit">Edit</button>
                                    <button class="btn btn-outline-primary" type="button" onclick="window.location.href='{{ route('admin.food.index') }}'" >Cancel</button>
                                </div>
                            </div>
                            <!--Hotel detail end-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    @section('custom_js')
        <script src="{{ asset('js/FormControls.js') }}"></script>
        <script>
            const btnSubmit = document.querySelector('button[type="submit"]');
            const formEl = $('#form_input');
            btnSubmit.addEventListener('click', function(e) {
                e.preventDefault();
                KTFormControls.onSubmitForm(formEl);
            });
        </script>
    @endsection
</x-app-layout>
