<x-app-layout title="Menu">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Detail Menu</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gx-lg-5">
                <div class="col-xl-4 col-md-8 mx-auto">
                    <div class="product-img-slider sticky-side-div">
                        <div
                            class="swiper product-thumbnail-slider p-2 rounded bg-light swiper-initialized swiper-horizontal swiper-pointer-events">
                            <div class="swiper-wrapper" id="swiper-wrapper-3d89eb772a51055d" aria-live="polite"
                                style="transform: translate3d(0px, 0px, 0px);">
                                <div class="swiper-slide swiper-slide-active mx-auto" role="group" aria-label="1 / 4"
                                    style="width: 218px; ">
                                    <img src="{{ asset('images/food/' . $food->cover) }}" alt=""
                                        class="img-fluid d-block" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="mt-xl-0 mt-5">
                        <div class="row mt-4">
                            <div class="col-lg-6 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-info fs-24">
                                                <i class="ri-file-list-3-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Nama</p>
                                            <h5 class="mb-0">{{ $food->title }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-info fs-24">
                                                @if ($food->category == 'Makanan')
                                                    <i class="ri-restaurant-fill"></i>
                                                @else
                                                    <i class="ri-goblet-fill"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Kategori </p>
                                            <h5 class="mb-0 text-capitalize">{{ $food->category }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-info fs-24">
                                                <i class="ri-money-dollar-circle-fill"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Harga</p>
                                            <h5 class="mb-0">{{ $food->price }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-info fs-24">
                                                <i class=" bx bx-package"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-muted mb-1">Stok Tersedia</p>
                                            <h5 class="mb-0">{{ $food->stock }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>


                    </div>
                    <div class="mt-4 text-muted">
                        <h5 class="fs-14">Description :</h5>
                        <p>{{ $food->description }}</p>
                    </div>
                </div>
                <div class="hstack gap-2 justify-content-end">
                    <a class="btn btn-light" href="{{ route('admin.order.index') }}">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
