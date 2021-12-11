@section('script')
    <script>
        // alert("<?php echo auth()->user()->id; ?>");
        function updatetable() {
            const userId = "<?php echo auth()->user()->id; ?>";
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById('tbody').innerHTML = this.responseText;
            }
            xhttp.open('GET', '/user/' + userId + '/Ajaxpurchased');
            xhttp.send();
        }
        setTimeout(function() {
            setInterval(updatetable, 1000);
        }, 1000);

    </script>
@endsection
<tbody id="tbody">
    @foreach ($purchase as $purch)
        <tr>
            <td>{{ $purch->name }}</td>
            <td>{{ $purch->user->name }}</td>
            <td>{{ $purch->user->email }}</td>
            <td>{{ $purch->user->phone_number ?? 'has not enterd' }}</td>
            <td>{{ $purch->quantity }}</td>
            <td>{{ $purch->price }}</td>
            <td>{{ $purch->total_price }}</td>
            @php
                if ($purch->status == 'order') {
                    $icon = 'fa fa-cart-arrow-down';
                    $color = 'text-warning';
                    $value = '30';
                    $prog_color = 'warning';
                } elseif ($purch->status == 'deliverd') {
                    $icon = 'fa fa-truck';
                    $color = 'text-info';
                    $value = '70';
                    $prog_color = 'info';
                } else {
                    $icon = 'fa fa-check';
                    $color = 'text-success';
                    $value = '100';
                    $prog_color = 'success';
                }
            @endphp
            <td class="{{ $color }}">{{ $purch->status }}
                <i class="{{ $icon }}"></i>
                <div class="progress" style="width:300px">
                    <div class="progress-bar bg-{{ $prog_color }}" role="progressbar" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100" style="width:{{ $value }}%">
                        {{ $value }}%
                    </div>
                </div>
            </td>
            <td>{{ $purch->date }}</td>
        </tr>
    @endforeach
</tbody>
