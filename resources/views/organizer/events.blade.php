

@extends('organizer.dashboard')

@section('title', 'Organizer Events')
@section('cdn')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
@endsection

@section('content')
    <table id="search-table">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        Company Name
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Ticker
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Stock Price
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Market Capitalization
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

@endsection

@section('scripts')
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endsection
