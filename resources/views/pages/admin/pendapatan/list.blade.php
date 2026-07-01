<div class="filter-container">
    <label for="start-date">Mulai Tanggal:</label>
    <input type="date" id="start-date">
    <label for="end-date">Sampai Tanggal:</label>
    <input type="date" id="end-date">
    <button type="button" onclick="applyFilter()">Terapkan</button>
</div>
<div class="card-body">
    <div>
        <div class="table-responsive table-card mb-1">
            <table class="table align-middle">
                <thead class="table-light text-muted">
                    <tr>
                        <!-- <th>Id Kas</th> -->
                        <th>Tanggal Penerimaan</th>
                        <th>Kas Keluar/Masuk</th>
                        <th>Jumlah</th>
                        <th>Sumber Kas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalIn = 0;
                    @endphp
                    @foreach ($kas as $item)
                        <tr>
                            <!-- <td>{{ $item->id }}</td> -->
                            <td>{{ $item->inout_date }}</td>
                            <td>Rp. {{ number_format($item->amount, 0, ',', '.') }}</td>
                            <td>{{ $item->transaction_type }}</td>
                            <td>
                                @if ($item->in_out === 'in')
                                    <button class="btn btn-success">MASUK</button>
                                    @php
                                        $totalIn += $item->amount;
                                    @endphp
                                @endif
                            </td>
                            <td>
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                        data-bs-placement="top" title="" data-bs-original-title="Remove">
                                        <a href="javascript:;"
                                            onclick="handle_confirm('Apakah Anda Yakin?','Yakin','Tidak','DELETE','{{ route('admin.pendapatan.destroy', $item->id) }}');"
                                            class="text-danger d-inline-block remove-item-btn">
                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                        </a>
                                    </li>
                                </ul>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card-footer">
    <strong>Total Kas Masuk: Rp {{ number_format($totalIn, 0, ',', '.') }}</strong>
    <br>
</div>
