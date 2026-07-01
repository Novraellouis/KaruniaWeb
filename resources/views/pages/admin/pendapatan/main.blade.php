<x-app-layout title="Data Pemesanan">
    <div id="content_list">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Data Kas Masuk</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row g-4">
                        <div class="col-sm justify-content-sm-start">
                            <div class="row g-4">
                                <div class="col-sm">
                                    <label for="start_date">From:</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        placeholder="Start Date">
                                </div>
                                <div class="col-sm">
                                    <label for="end_date">To:</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        placeholder="End Date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm justify-content-sm-start">
                            <div class="row g-4">
                                <div class="col-sm-1"><br>
                                    <button class="btn btn-info me-2" onclick="exportPDF()">Export
                                        PDF</button>
                                </div>
                            </div>

                            <!-- <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <form id="content_filter">
                                            <input type="text" name="keyword" onkeyup="load_list(1);"
                                                class="form-control" placeholder="Cari Data Pesanan...">
                                            <i class="ri-search-line search-icon"></i>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div id="list_result"></div>
                </div>
            </div>
        </div>
        <div id="content_detail"></div>
        @section('custom_js')
            <script>
                load_list(1);
            </script>
            <script>
                function exportPDF() {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;

                    window.open(`{{ route('admin.pendapatan.pdf') }}?start_date=${startDate}&end_date=${endDate}`,
                        '_blank');
                }
            </script>
            <script>
                function applyFilter() {
                    const startDate = document.getElementById('start-date').value;
                    const endDate = document.getElementById('end-date').value;

                    // Convert the date strings to Date objects
                    const startDateTime = new Date(startDate).getTime();
                    const endDateTime = new Date(endDate).getTime();

                    const tableRows = document.querySelectorAll('.table tbody tr');

                    tableRows.forEach((row) => {
                        const dateValue = new Date(row.cells[2].textContent).getTime();

                        if (dateValue >= startDateTime && dateValue <= endDateTime) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update the total based on filtered rows
                    updateTotal();
                }

                function updateTotal() {
                    const tableRows = document.querySelectorAll('.table tbody tr');
                    let totalIn = 0;

                    tableRows.forEach((row) => {
                        const isIn = row.cells[5].querySelector('button.btn-success');

                        if (isIn && row.style.display !== 'none') {
                            const amountText = row.cells[3].textContent.replace(/\D/g, ''); // Remove non-numeric characters
                            const amount = parseInt(amountText);
                            totalIn += amount;
                        }
                    });

                    document.querySelector('.card-footer strong').textContent = 'Total Kas Masuk: Rp ' + formatNumber(totalIn);
                }

                // Helper function to format the number with commas
                function formatNumber(number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }
            </script>

            {{-- <script>
            // Function to filter data based on selected dates
            function filterData() {
                // Get the selected start and end dates
                const startDate = new Date(document.getElementById('start_date').value);
                const endDate = new Date(document.getElementById('end_date').value);

                // Get the data to be filtered (replace this with your actual data source)
                const data = [{
                        date: '2023-07-23',
                        value: 'Data 1'
                    },
                    {
                        date: '2023-07-24',
                        value: 'Data 2'
                    },
                    {
                        date: '2023-07-25',
                        value: 'Data 3'
                    },
                    // Add more data here
                ];

                // Filter the data based on the selected dates
                const filteredData = data.filter(item => {
                    const itemDate = new Date(item.date);
                    return itemDate >= startDate && itemDate <= endDate;
                });

                // Display the filtered data
                const filteredDataElement = document.getElementById('filtered_data');
                filteredDataElement.innerHTML = ''; // Clear previous data
                filteredData.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.textContent = item.value;
                    filteredDataElement.appendChild(itemDiv);
                });
            }

            // Attach the filterData function to the change event of date inputs
            document.getElementById('start_date').addEventListener('change', filterData);
            document.getElementById('end_date').addEventListener('change', filterData);
        </script> --}}
        @endsection
</x-app-layout>
