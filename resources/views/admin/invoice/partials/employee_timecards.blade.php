@if ($taskData->count() > 0)
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Job</th>
                <th>Total Hours</th>
                <th>Total Amount</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandHours = 0;
                $grandAmount = 0;
            @endphp
            @foreach ($taskData as $index => $card)
                @php
                    $grandHours += $card->total_hours;
                    $grandAmount += $card->total_amount;
                @endphp
                <tr>
                    <td>{{ optional($card->employee?->user)->first_name }}
                        {{ optional($card->employee?->user)->last_name }}</td>
                    <td>{{ optional($card->employee?->job)->name ?? '-' }}</td>
                    <td>{{ number_format($card->total_hours, 2) }}</td>
                    <td>${{ number_format($card->total_amount, 2) }}</td>
                    <td>{{ $card->start_date }}</td>
                    <td>{{ $card->end_date }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.singleInvoiceStore') }}">
                            @csrf
                            <input type="hidden" name="hotel_id" value="{{ $card->employee->hotel_id }}">
                            <input type="hidden" name="due_date" value="{{ now()->addDays(7)->toDateString() }}">
                            <input type="hidden" name="item[employee_id]" value="{{ $card->employee->id }}">
                            <input type="hidden" name="item[service]"
                                value="{{ optional($card->employee?->job)->name }}">
                            <input type="hidden" name="item[time]" value="{{ $card->total_hours }}">
                            <input type="hidden" name="item[price_per_unit]" value="{{ $card->employee->pay_rate }}">
                            <input type="hidden" name="item[platform_fee]" value="{{ $card->platform_fee }}">
                            <input type="hidden" name="item[total]" value="{{ $card->total_amount }}">
                            <input type="hidden" name="item[start_date]" value="{{ $card->start_date }}">
                            <input type="hidden" name="item[end_date]" value="{{ $card->end_date }}">
                            <input type="hidden" name="item[task_item_id]" value="{{ $card->task_item_id }}">
                            <button type="submit" class="btn btn-sm btn-primary">Send Invoice</button>
                        </form>

                        <div class="item-data d-none" data-employee-id="{{ $card->employee->id }}"
                            data-service="{{ optional($card->employee?->job)->name }}"
                            data-time="{{ $card->total_hours }}" data-price="{{ $card->employee->pay_rate }}"
                            data-platform-fee="{{ $card->platform_fee }}" data-total="{{ $card->total_amount }}"
                            data-start="{{ $card->start_date }}" data-end="{{ $card->end_date }}"
                            data-task-item-id="{{ $card->task_item_id }}">
                        </div>
                    </td>
                </tr>
            @endforeach

            <tr class="font-weight-bold bg-light">
                <td></td>
                <td></td>
                <td colspan="3" class="text-right">Total</td>
                <td>${{ number_format($grandAmount, 2) }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.InvoiceStore') }}"
                        onsubmit="return populateTaskItems()">
                        @csrf
                        <input type="hidden" name="hotel_id"
                            value="{{ optional($taskData->first()->employee)->hotel_id }}">
                        <input type="hidden" name="due_date" value="{{ now()->addDays(7)->toDateString() }}">
                        <input type="hidden" name="items" id="items-json" value="">
                        <button type="submit" class="btn btn-success btn-sm">Bulk Send Invoice</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@else
    <p class="text-danger mt-3" style="margin-left: 189px;">No task items found for this hotel's employees.</p>
@endif

<script>
    function populateTaskItems() {
        let items = [];

        document.querySelectorAll('.item-data').forEach(function(div) {
            items.push({
                employee_id: div.dataset.employeeId,
                service: div.dataset.service,
                quantity: 0,
                time: parseFloat(div.dataset.time),
                price_per_unit: parseFloat(div.dataset.price),
                platform_fee: parseFloat(div.dataset.platformFee),
                total: parseFloat(div.dataset.total),
                start_date: div.dataset.start,
                end_date: div.dataset.end,
                task_item_id: div.dataset.taskItemId
            });
        });

        document.getElementById('items-json').value = JSON.stringify(items);
        return true;
    }
</script>
