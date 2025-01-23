<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th rowspan="2" style="width: 20%;"><b>Nombre de la Entidad</b></th>
            <th rowspan="2"><b>Tipo Crédito</b></th>
            <th colspan="3"><b>Deuda Anterior</b></th>
            @php
                $textMonth = "";
                $j = 0;
                foreach($latestMonth as $key => $value) {
                    if ($j == 3) {
                        $textMonth = $value;
                    }
                    $j++;
                }
            @endphp
            <th colspan="3"><b>Deuda a {{$textMonth}}</b></th>
        </tr>
        <tr>
            @php
                $k = 0;
            @endphp
            @foreach($latestMonth as $key => $value)
                @if($k <=2)
                    <th><b>{{$value}}</b></th>
                @endif
                @php
                    $k++;
                @endphp
            @endforeach
            <th><b>Fecha Inf.</b></th>
            <th><b>Calif.</b></th>
            <th><b>Monto</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($sbsLatestMonth as $key => $value)
            @foreach($value as $key2 => $value2)
                <tr>
                    <td>{{$key}}</td>
                    <td style="text-align: center;">{{$key2}}</td>
                    @php
                        $m = 0;
                        $keyTmp = "";
                    @endphp
                    @foreach($latestMonth as $key3 => $value3)
                        @php
                            
                            $amount = 0;
                            if ($m <=2) {
                                $detailTmp = $value2[$key3];
                                foreach($detailTmp as $key4 => $value4) {
                                    $amount+=$value4['amount'];
                                }
                            }
                        @endphp
                        @if($m<=2)
                            <td>{{$amount}}</td>
                        @else
                            <td>{{$latest}}</td>
                        @endif
                        @php
                            $m++;
                            $keyTmp = $key3;
                        @endphp
                    @endforeach
                    @if(isset($sbsLatestMonthRating[$keyTmp]))
                        @switch($sbsLatestMonthRating[$keyTmp])
                            @case('normal_rating')
                                <td><label class="form-control label-rating label-normal"><b>NOR</b></label></td>
                                @break
                            @case('cpp_rating')
                                <td><label class="form-control label-rating label-cpp"><b>CPP</b></label></td>
                                @break
                            @case('deficient_rating')
                                <td><label class="form-control label-rating label-deficient"><b>DEF</b></label></td>
                                @break
                            @case('uncertain_rating')
                                <td><label class="form-control label-rating label-uncertain"><b>DUD</b></label></td>
                                @break
                            @case('lost_rating')
                                <td><label class="form-control label-rating label-lost"><b>PER</b></label></td>
                                @break
                            @case('unrated_rating')
                                <td><label class="form-control label-rating label-unrated"><b>SCAL</b></label></td>
                                @break
                            @default
                                <td>DEFAULT</td>
                        @endswitch
                    @else
                        <td>NO RATING</td>
                    @endif
                    @php
                        $amount = 0;
                        $detailTmp = $value2[$keyTmp];
                        foreach($detailTmp as $key4 => $value4) {
                            $amount+=$value4['amount'];
                        }
                    @endphp
                    <td>{{$amount}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>