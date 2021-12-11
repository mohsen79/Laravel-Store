@component('admin.layouts.content', ['title' => 'Purchased'])
    <a href="/" class="btn btn-outline-light float-right m-3">Home</a>
    <h2>In Process Orders</h2>
    <p id="p"></p>
    <table class="table table-hover">
        <tr>
            <th>Product Name</th>
            <th>user Name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        @include('InnerPurchase')
    </table>
    <style>
        progress {
            -webkit-appearance: none;
        }

        ::-webkit-progress-bar {
            background-color: rgb(68, 0, 255);
        }

    </style>
@endcomponent
