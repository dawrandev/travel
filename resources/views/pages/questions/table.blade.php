<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>№</th>
                <th>Тур</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Вопрос</th>
                <th>Статус</th>
                <th>Создано</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($questions as $question)
            <tr>
                <td>{{ $loop->iteration + ($questions->currentPage() - 1) * $questions->perPage() }}</td>
                <td>
                    @if($question->tour)
                        {{ $question->tour->translations->where('lang_code', 'ru')->first()->title ?? $question->tour->translations->first()->title ?? 'N/A' }}
                    @else
                        <span class="text-muted">Тур удален</span>
                    @endif
                </td>
                <td>{{ $question->full_name }}</td>
                <td>{{ $question->email }}</td>
                <td>{{ $question->phone }}</td>
                <td>
                    <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $question->comment }}">
                        {{ Str::limit($question->comment, 50) }}
                    </div>
                </td>
                <td>
                    @php
                        $statusLabels = [
                            'pending' => ['text' => 'В ожидании', 'class' => 'badge-warning'],
                            'answered' => ['text' => 'Отвечено', 'class' => 'badge-success'],
                        ];
                        $status = $statusLabels[$question->status] ?? ['text' => $question->status, 'class' => 'badge-secondary'];
                    @endphp
                    <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                </td>
                <td>{{ $question->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm view-question" data-id="{{ $question->id }}" title="Просмотр">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm edit-status" data-id="{{ $question->id }}" data-status="{{ $question->status }}" title="Изменить статус">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;" data-confirm-delete data-item-name="вопрос">
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
                <td colspan="9" class="text-center text-muted">Вопросов не найдено</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{ $questions->appends(request()->query())->links() }}
</div>

