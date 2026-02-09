<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>№</th>
                <th>Тур</th>
                <th>Клиент</th>
                <th>Email</th>
                <th>Телефон 1</th>
                <th>Телефон 2</th>
                <th>Людей</th>
                <th>Дата начала</th>
                <th>Дата окончания</th>
                <th>Статус</th>
                <th>Создано</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td>{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                <td>
                    @if($booking->tour)
                        {{ $booking->tour->translations->where('lang_code', 'ru')->first()->title ?? $booking->tour->translations->first()->title ?? 'N/A' }}
                    @else
                        <span class="text-muted">Тур удален</span>
                    @endif
                </td>
                <td>{{ $booking->full_name }}</td>
                <td>{{ $booking->email }}</td>
                <td>{{ $booking->primary_phone }}</td>
                <td>{{ $booking->secondary_phone ?? '-' }}</td>
                <td>{{ $booking->max_people }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->starting_date)->format('d.m.Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->ending_date)->format('d.m.Y') }}</td>
                <td>
                    @php
                        $statusLabels = [
                            'pending' => ['text' => 'В ожидании', 'class' => 'badge-warning'],
                            'confirmed' => ['text' => 'Подтверждено', 'class' => 'badge-success'],
                            'cancelled' => ['text' => 'Отменено', 'class' => 'badge-danger'],
                        ];
                        $status = $statusLabels[$booking->status] ?? ['text' => $booking->status, 'class' => 'badge-secondary'];
                    @endphp
                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                </td>
                <td>{{ $booking->created_at->format('d.m.Y H:i') }}</td>
                <td style="white-space: nowrap;">
                    <button type="button" class="btn btn-info btn-sm view-booking" data-id="{{ $booking->id }}" title="Просмотр">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm edit-status" data-id="{{ $booking->id }}" data-status="{{ $booking->status }}" title="Изменить статус">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="бронирование">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Удалить">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center text-muted">Бронирований не найдено</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{ $bookings->appends(request()->query())->links() }}
</div>
