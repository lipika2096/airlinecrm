@extends('admin/layouts/head-main')
@section('title', 'Customer Ledger')
@section('content')

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Customer Ledger</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customer Ledger</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        
                        <!-- Search/Filter Section -->
                        <div class="filter-section mb-4">
                            <div class="row align-items-end">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Search:</label>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>From:</label>
                                        <input type="date" class="form-control" id="fromDate">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>To:</label>
                                        <input type="date" class="form-control" id="toDate">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Search Type:</label>
                                        <select class="form-control" id="searchType">
                                            <option value="description">Description</option>
                                            <option value="amount">Amount</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="btn btn-warning" id="downloadReport">
                                            <i class="fa fa-download"></i> Download Report
                                        </button>
                                        <button class="btn btn-warning" id="submitFilter">
                                            <i class="fa fa-search"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Year Navigation -->
                        <div class="year-navigation mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button class="btn btn-outline-secondary btn-sm" id="prevYear">
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <h4 class="mx-3 mb-0" id="currentYear">Year {{ date('Y') }}</h4>
                                        <button class="btn btn-outline-secondary btn-sm" id="nextYear">
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Month Buttons -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 1 ? 'active' : '' }}" data-month="1">JAN</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 2 ? 'active' : '' }}" data-month="2">Feb</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 3 ? 'active' : '' }}" data-month="3">Mar</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 4 ? 'active' : '' }}" data-month="4">APR</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 5 ? 'active' : '' }}" data-month="5">MAY</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 6 ? 'active' : '' }}" data-month="6">JUN</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 7 ? 'active' : '' }}" data-month="7">JUL</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 8 ? 'active' : '' }}" data-month="8">AUG</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 9 ? 'active' : '' }}" data-month="9">SEP</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 10 ? 'active' : '' }}" data-month="10">OCT</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 11 ? 'active' : '' }}" data-month="11">NOV</button>
                                        <button class="btn btn-outline-primary btn-sm month-btn {{ date('m') == 12 ? 'active' : '' }}" data-month="12">DEC</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Entry Type Filters -->
                        <div class="entry-type-filters mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary entry-filter active" data-filter="all">
                                            All Entries
                                        </button>
                                        <button class="btn btn-outline-secondary entry-filter" data-filter="credit">
                                            Credit Entries only
                                        </button>
                                        <button class="btn btn-outline-secondary entry-filter" data-filter="debit">
                                            Debit Entries only
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ledger Table -->
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0" id="ledgerTable">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Description</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody id="ledgerBody">
                                    @if(isset($flatLedger) && count($flatLedger) > 0)
                                        @foreach($flatLedger as $entry)
                                            <tr class="ledger-row {{ $entry['is_opening'] ? 'opening-row' : '' }}" 
                                                data-date="{{ $entry['date'] }}"
                                                data-description="{{ $entry['description'] }}"
                                                data-debit="{{ $entry['debit'] }}"
                                                data-credit="{{ $entry['credit'] }}"
                                                data-type="{{ $entry['debit'] > 0 ? 'debit' : ($entry['credit'] > 0 ? 'credit' : 'opening') }}">
                                                <td>{{ $entry['sno'] }}</td>
                                                <td>{{ $entry['date'] ? \Carbon\Carbon::parse($entry['date'])->format('d M Y H:i') : '-' }}</td>
                                                <td>{{ $entry['customer_name'] }}</td>
                                                <td>
                                                    <strong>{{ $entry['description'] }}</strong>
                                                    @if(isset($entry['booking_id']) && $entry['booking_id'])
                                                        <br><small class="text-muted">Booking ID: {{ $entry['booking_id'] }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-danger">
                                                    {{ $entry['debit'] > 0 ? number_format($entry['debit'], 2) : '-' }}
                                                </td>
                                                <td class="text-success">
                                                    {{ $entry['credit'] > 0 ? number_format($entry['credit'], 2) : '-' }}
                                                </td>
                                                <td><strong>{{ number_format($entry['balance'], 2) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No ledger entries found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
</div>
<!-- /Page Wrapper -->

<style>
    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }

    .year-navigation {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .entry-type-filters {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }

    .entry-filter.active {
        background-color: #007bff !important;
        color: white !important;
        border-color: #007bff !important;
    }

    .month-btn.active {
        background-color: #007bff !important;
        color: white !important;
    }

    .ledger-table th {
        background-color: #343a40;
        color: white;
    }

    .ledger-row:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    // Year Navigation
    let currentYear = {{ date('Y') }};
    let selectedMonth = {{ date('m') }};
    
    document.getElementById('prevYear').addEventListener('click', function() {
        currentYear--;
        document.getElementById('currentYear').textContent = 'Year ' + currentYear;
        filterLedger();
    });

    document.getElementById('nextYear').addEventListener('click', function() {
        currentYear++;
        document.getElementById('currentYear').textContent = 'Year ' + currentYear;
        filterLedger();
    });

    // Month Selection
    document.querySelectorAll('.month-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.month-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            selectedMonth = this.getAttribute('data-month');
            filterLedger();
        });
    });

    // Entry Type Filters
    let selectedFilter = 'all';
    document.querySelectorAll('.entry-filter').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.entry-filter').forEach(function(b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            selectedFilter = this.getAttribute('data-filter');
            filterLedger();
        });
    });

    // Search Functionality
    document.getElementById('searchInput').addEventListener('input', filterLedger);
    document.getElementById('fromDate').addEventListener('change', filterLedger);
    document.getElementById('toDate').addEventListener('change', filterLedger);
    document.getElementById('searchType').addEventListener('change', filterLedger);

    // Submit Filter
    document.getElementById('submitFilter').addEventListener('click', function() {
        filterLedger();
    });

    // Download Report
    document.getElementById('downloadReport').addEventListener('click', function() {
        // Implement download functionality
        alert('Download report functionality will be implemented');
    });

    function filterLedger() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const searchType = document.getElementById('searchType').value;
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;
        
        const rows = document.querySelectorAll('.ledger-row');
        let visibleCount = 0;

        rows.forEach(function(row) {
            const rowDate = row.getAttribute('data-date');
            const description = row.getAttribute('data-description').toLowerCase();
            const debit = parseFloat(row.getAttribute('data-debit'));
            const credit = parseFloat(row.getAttribute('data-credit'));
            const type = row.getAttribute('data-type');
            
            let showRow = true;

            // Filter by search term
            if (searchTerm) {
                if (searchType === 'description') {
                    if (!description.includes(searchTerm)) {
                        showRow = false;
                    }
                } else if (searchType === 'amount') {
                    const amount = debit > 0 ? debit : credit;
                    if (!amount.toString().includes(searchTerm)) {
                        showRow = false;
                    }
                }
            }

            // Filter by date range
            if (fromDate && rowDate < fromDate) {
                showRow = false;
            }
            if (toDate && rowDate > toDate) {
                showRow = false;
            }

            // Filter by year
            const rowYear = new Date(rowDate).getFullYear();
            if (rowYear !== currentYear) {
                showRow = false;
            }

            // Filter by month
            if (selectedMonth) {
                const rowMonth = new Date(rowDate).getMonth() + 1;
                if (rowMonth !== parseInt(selectedMonth)) {
                    showRow = false;
                }
            }

            // Filter by entry type
            if (selectedFilter !== 'all') {
                if (selectedFilter === 'credit' && type !== 'credit') {
                    showRow = false;
                }
                if (selectedFilter === 'debit' && type !== 'debit') {
                    showRow = false;
                }
            }

            if (showRow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update serial numbers
        let sno = 1;
        rows.forEach(function(row) {
            if (row.style.display !== 'none') {
                row.querySelector('td:first-child').textContent = sno++;
            }
        });

        // Show message if no results
        if (visibleCount === 0) {
            const tbody = document.getElementById('ledgerBody');
            if (!document.querySelector('#noResults')) {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResults';
                noResultsRow.innerHTML = '<td colspan="7" class="text-center">No ledger entries found matching your criteria</td>';
                tbody.appendChild(noResultsRow);
            }
        } else {
            const noResultsRow = document.querySelector('#noResults');
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    }
</script>

@endsection
