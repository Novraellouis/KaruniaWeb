<x-web-layout title="Hotel">
    <!--Start Sub Banner-->
    <div class="sub-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="detail">
                        <h1>Hotel</h1>
                        <span>Karunia Sipoholon</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-img"></div>
    </div>


    <!--End Sub Banner-->



    <!--Start Content-->
    <div class="content">

        <!--Start Rooms-->
        <div class="hotel-rooms">

            <div class="container">
                <div class="row">
                    @foreach ($penginapan as $item)
                        <div class="col-md-12">

                            <div class="room-sec">
                                <a href="{{ route('web.penginapan.detail', $item->id) }}"><img
                                        src="{{ asset('images/hotel/' . $item->cover) }}" alt=""></a>

                                <div class="text-detail">
                                    <h4>{{ $item->name }}</h4>
                                    <p>{{ $item->description }}
                                    </p>
                                    <ul>
                                        <li><i class="icon-long-arrow-right"></i> <span>{{ $item->category }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="price-detail">

                                    {{-- <div class="stars">
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                        <i class="icon-star3"></i>
                                    </div> --}}

                                    <div class="room-price">
                                        <span class="current">Rp
                                            {{ $item->price }}</span>
                                        <span class="per-night">Per night</span>
                                    </div>

                                    <a href="{{ route('web.penginapan.detail', $item->id) }}">room detail</a>

                                </div>


                            </div>
                        </div>
                    @endforeach
                </div>






                <div class="paging">
                    {{ $penginapan->links() }}
                </div>


            </div>

        </div>
    </div>

    </div>
    <!--End Rooms-->

    </div>
    <!--End Content-->
</x-web-layout>
