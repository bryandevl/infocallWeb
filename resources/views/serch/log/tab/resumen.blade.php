<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Período</label>
            <select class="form-control selectpicker" id="slct_cPERIODO" data-live-search="true">
                <option value="">Todos</option>
                @foreach($cPeriodoArray as $key => $value)
                <option value="{{$value}}" {{($key == 0)? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Campaña</label>
            <select class="form-control selectpicker" id="slct_campaign_id" data-live-search="true">
                <option value="">Todos</option>
                @foreach($campaignArray as $key => $value)
                <option value="{{$value}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <br>
        <button class="btn btn-success" id="btn-resumen">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-6" id="contentChartTotales"></div>
    <div class="col-md-6" id="contentChartCampaigns"></div>
</div>