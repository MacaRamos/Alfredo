<div class="card-body table-responsive p-0">
    <table class="table table-bordered-calendar" id="tablaSemana">
        <thead style="background-color: #fafafa;">
            <tr>
                <th style="min-width: 100px;">Lunes</th>
                <th style="min-width: 100px;">Martes</th>
                <th style="min-width: 100px;">Miércoles</th>
                <th style="min-width: 100px;">Jueves</th>
                <th style="min-width: 100px;">Viernes</th>
                <th style="min-width: 100px;">Sábado</th>
                <th style="min-width: 100px;">Domingo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mes as $semana)
            <tr style="height: 100px;">
                @for ($i = 1; $i <= 7; $i++)
                    @if (isset($semana->semana[$i]))
                        <td>{{$semana->semana[$i]->Fecha}}</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
</div>