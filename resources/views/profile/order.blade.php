@extends('components.layouts.app')

@section('title', 'Order Summary')

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9">
                    <div class="account-information">
                        <h1>Orders</h1>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>System Architect</td>
                                    <td>$20.00</td>
                                    <td>
                                        <div class="action-btn">
                                            <a href="#" class="btn custom-btn filled">View</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Accountant</td>
                                    <td>$20.00</td>
                                    <td>
                                        <div class="action-btn">
                                            <a href="#" class="btn custom-btn filled">View</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>System Architect</td>
                                    <td>$20.00</td>
                                    <td>
                                        <div class="action-btn">
                                            <a href="#" class="btn custom-btn filled">View</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Accountant</td>
                                    <td>$20.00</td>
                                    <td>
                                        <div class="action-btn">
                                            <a href="#" class="btn custom-btn filled">View</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
@endpush
