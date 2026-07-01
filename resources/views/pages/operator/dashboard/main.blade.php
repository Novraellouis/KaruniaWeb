<x-app-layout title="Dashboard">
    <h5>Dashboard</h5>
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="invoiceList">
                <div class="card-header border-0">
                    <div class="card-body">
                        <div>
                            <div class="table-responsive text-center container">
                                <lord-icon src="https://cdn.lordicon.com/eszyyflr.json" trigger="loop"
                                    style="width:130px;height:130px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <h2 class="mb-0 flex-grow-1 text-center">Welcome Back {{ Auth::user()->fullname }}!</h2>
                    </div><br>
                    <div class="d-flex align-items-center justify-content-center pb-5">
                        <h4 class="mb-0 flex-grow-1 text-center">KaruniaSipoholon</h4>
                    </div>
                </div>

            </div>

        </div>
        <!--end col-->
    </div>
</x-app-layout>
