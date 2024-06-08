@extends('layout')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h2>Статистика по курсам</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Название курса</th>
                    <th>Описание</th>
                    <th>Средняя оценка</th>
                    <th>Общее количество прохождений</th>
                    <th>Рейтинги</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($curses as $curse)
                    <tr>
                        <td>{{ $curse->Name }}</td>
                        <td>{{ $curse->Description }}</td>
                        <td>{{ round($curse->ratings_avg, 2) }}</td>
                        <td>{{ $curse->ratings_count }}</td>
                        <td>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Пользователь</th>
                                        <th>Оценка</th>
                                        <th>Дата и время оценки</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curse->ratings as $rating)
                                        <tr>
                                            <td>{{ $rating->user->name }}</td>
                                            <td>{{ $rating->rating }}</td>
                                            <td>{{ $rating->created_at }}</td> <!-- Добавлено -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
