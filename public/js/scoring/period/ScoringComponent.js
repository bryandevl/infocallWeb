'use strict';
const { useState } = React;
const appRoot = document.getElementById('scoring_component');

const SERVER_SCORING = crScoringEndpoint;

const ScoringComponent = () => {
  const [responsePeriod, setResponsePeriod] = useState({
    success: [],
    errors: [],
  });
  const [scoringParams, setScoringParams] = useState({});

  return (
    <div className='container-fluid spark-screen'>
      <div className='row'>
        <div className='col-md-9 col-md-offset-1'>
          <RunPeriodComponent
            responseDataPeriod={setResponsePeriod}
            setScoringParams={setScoringParams}
          />
          <ScoringTableComponent scoringData={responsePeriod} scoringParams={scoringParams} />
        </div>
      </div>
    </div>
  );
};

const root = ReactDOM.createRoot(appRoot);
root.render(<ScoringComponent />);
